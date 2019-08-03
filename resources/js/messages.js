import moment from "moment";

$(function () {

    let Vm_main = new Vue({
        el: '#js-main-block',
        data: {
            messages_list: [],
            get_data_url: $('#js-get-data-url').val(),
            is_data_error: 0
        },
        mounted: function(){
            this.getData();
        },
        methods: {
            getData: function(){
                const self = this;
                self.messages_list = [];

                axios.get(this.get_data_url)
                .then(function (response) {
                    self.messages_list = response.data.content;
                    console.log(self.messages_list);
                })
                .catch(function () {
                    self.messages_list = [];
                    self.is_data_error = 1;
                });
            },
            clickAddMessageButton: function(){
                Vm_modal.showSaveMessageModal(null, '', 0);
            },
            clickEditMessageButton(message_id){

                let $message_block = $('#message_block_' + message_id);
                let message_text = $message_block.data('text');
                let is_message_private = $message_block.data('private');

                Vm_modal.showSaveMessageModal(message_id, message_text, is_message_private);
            },
            clickDeleteMessageButton(message_id){
                Vm_modal.showDeleteMessageModal(message_id);
            },
            decodeString(string){
                return decodeURIComponent(escape(window.atob(string)));
            }
        }
    });

    let Vm_modal = new Vue({
        el: '#js-modals-block',
        data: {
            send_message_modal_head_title: '',
            save_message_url: $('#js-save-message-url').val(),
            delete_message_url: $('#js-delete-message-url').val(),
            token: $('#js-token').val()
        },
        mounted: function(){
            $('#saveMessageModal').on('hidden', function(){
                $('#js-send-message-modal-message-id').val('');
                $('#js-send-message-modal-is-private').prop('checked', false);
                $('#js-send-message-modal-textarea').val('');
            });
        },
        methods: {
            showSaveMessageModal: function(message_id, message_text, is_message_private){
                const self = this;
                self.send_message_modal_head_title = message_id ? 'Редактирование сообщения' : 'Добавление сообщения';

                $('#js-send-message-modal-error-block').addClass('hidden');
                $('#js-send-message-modal-message-id').val((message_id ? message_id : ''));
                $('#js-send-message-modal-is-private').prop('checked', !!is_message_private);
                $('#js-send-message-modal-textarea').val(message_text);
                $('#saveMessageModal').modal('show');
            },
            showDeleteMessageModal: function(message_id){

                $('#js-delete-message-modal-message-id').val(message_id);
                $('#deleteMessageModal').modal('show');
            },
            saveMessage(){
                const self = this;
                let message_id = $('#js-send-message-modal-message-id').val();
                let is_message_private = $("#js-send-message-modal-is-private").is(':checked') ? 1 : 0;
                let message_text = $('#js-send-message-modal-textarea').val();

                if($.trim(message_text).length !== 0){ // Если тескст сообщения не пустой и не состоит из одних пробелов

                    let params_list = {
                        _token: self.token,
                        message_text: (is_message_private ? window.btoa(unescape(encodeURIComponent(message_text))) : message_text),
                        is_message_private: is_message_private
                    };
                    if(message_id){
                        params_list.message_id = message_id;
                    }

                    axios.get(self.save_message_url, {params: params_list})
                    .then(function (response) {
                        console.log(response);
                        Vm_main.getData();
                    })
                    .catch(function () {

                    })
                    .then(function () {
                        $('#saveMessageModal').modal('hide');
                    });
                }
                else{
                    $('#js-send-message-modal-error-block').removeClass('hidden');
                    $('#js-send-message-modal-textarea').val('').focus();
                }
            },
            deleteMessage(){
                const self = this;
                let message_id = $('#js-delete-message-modal-message-id').val();

                axios.get(self.delete_message_url, {
                    params: {
                        _token: self.token,
                        message_id: message_id
                    }
                })
                .then(function (response) {
                    if(response.data.status === 'ok'){
                        Vm_main.getData();
                    }
                })
                .catch(function () {

                })
                .then(function () {
                    $('#deleteMessageModal').modal('hide');
                });
            }
        }
    });

});