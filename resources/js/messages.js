import moment from "moment";

$(function () {

    let Vm_main = new Vue({ // Объект Vue для основного контента страницы
        el: '#js-main-block',
        data: {
            messages_list: [], // Список всех сообщений
            get_data_url: $('#js-get-data-url').val(), // url для получения списка сообщений
            is_data_error: 0, // Произошла ли ошибка
            notify_text: '' // Текст уведомления
        },
        mounted: function(){
            this.getData();
        },
        methods: {
            getData: function(){ // Получить список всех сообщений
                const self = this;
                self.messages_list = [];

                axios.get(this.get_data_url)
                .then(function (response) {
                    self.messages_list = response.data.content;
                    console.log(self.messages_list);
                })
                .catch(function () {
                    self.is_data_error = 1;
                });
            },
            clickAddMessageButton: function(){ // Нажатие на кнопку "Добавить"
                Vm_modal.showSaveMessageModal(null, '', 0);
            },
            clickEditMessageButton(message_id){ // Нажатие на кнопку "Редактировать"
                let $message_block = $('#message_block_' + message_id);
                let message_text = $message_block.data('text');
                let is_message_private = $message_block.data('private');

                Vm_modal.showSaveMessageModal(message_id, message_text, is_message_private);
            },
            clickDeleteMessageButton(message_id){ // Нажатие на кнопку "Удалить"
                Vm_modal.showDeleteMessageModal(message_id);
            },
            decodeString(string){ // Раскодировать "приватное" сообщение
                return decodeURIComponent(escape(window.atob(string)));
            },
            transformDate(date){ // Преобразовать дату в формат без секунд
                return moment(date, 'YYYY-DD-MM HH:mm:ss').format('YYYY-DD-MM H:mm');
            },
            showNotify(notify_text, is_error){ // Показать уведомление о сохранении/изменении/удалении сообщения
                const self = this;
                self.notify_text = notify_text;

                if(!is_error){
                    $('#js-notify-block').removeClass('hidden').addClass('alert-success');
                }
                else{
                    $('#js-notify-block').removeClass('hidden').addClass('alert-error');
                }

                setTimeout(function(){
                    $('#js-notify-block').removeClass('alert-success alert-error').addClass('hidden');
                }, 3000);
            }
        }
    });

    let Vm_modal = new Vue({ // Объект Vue для модалок
        el: '#js-modals-block',
        data: {
            send_message_modal_head_title: '', // Текст заголовка в модалке ("Создание"/"Редактирование")
            save_message_url: $('#js-save-message-url').val(), // url для отправки сообщения (нового/отредактированного)
            delete_message_url: $('#js-delete-message-url').val(), // url для удаления сообщения
            token: $('#js-token').val() // Значение токена
        },
        mounted: function(){
            $('#saveMessageModal').on('hidden', function(){ // Очистка модалки сообщения от прежних значений при ее закрытии
                $('#js-send-message-modal-message-id').val('');
                $('#js-send-message-modal-is-private').prop('checked', false);
                $('#js-send-message-modal-textarea').val('');
            });
        },
        methods: {
            // Открыть модалку для создания/редактирования сообщения
            showSaveMessageModal: function(message_id, message_text, is_message_private){
                const self = this;
                self.send_message_modal_head_title = message_id ? 'Редактирование сообщения' : 'Добавление сообщения';

                $('#js-send-message-modal-error-block').addClass('hidden');
                $('#js-send-message-modal-message-id').val((message_id ? message_id : ''));
                $('#js-send-message-modal-is-private').prop('checked', !!is_message_private);
                $('#js-send-message-modal-textarea').val(message_text);
                $('#saveMessageModal').modal('show');
            },
            showDeleteMessageModal: function(message_id){ // Открыть модалку для удаления сообщения
                $('#js-delete-message-modal-message-id').val(message_id);
                $('#deleteMessageModal').modal('show');
            },
            saveMessage(){ // Отправить запрос с новым/отредактированным сообщением
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
                        if(response.data.status === 'ok'){
                            Vm_main.getData();
                            Vm_main.showNotify((message_id ? 'Сообщение успешно изменено!' : 'Сообщение успешно создано!'), 0);
                        }
                        else{
                            Vm_main.showNotify('Произошла ошибка, попробуйте повторить попытку!', 1);
                        }
                    })
                    .catch(function () {
                        Vm_main.showNotify('Произошла ошибка, попробуйте повторить попытку!', 1);
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
            deleteMessage(){ // Отправить запрос на удаление сообщения
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
                        Vm_main.showNotify('Сообщение успешно удалено!', 0);
                    }
                    else{
                        Vm_main.showNotify('Произошла ошибка, попробуйте повторить попытку!', 1);
                    }
                })
                .catch(function () {
                    Vm_main.showNotify('Произошла ошибка, попробуйте повторить попытку!', 1);
                })
                .then(function () {
                    $('#deleteMessageModal').modal('hide');
                });
            }
        }
    });

});