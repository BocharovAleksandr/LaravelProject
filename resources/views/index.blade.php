@extends('layout.main')

@section('content')
<div class="row-fluid" id="js-main-block" v-cloak>

    <div class="span2"></div>
    <div class="span8">
        <input type="hidden" id="js-get-data-url" value="{{ route('home.get_data') }}">

        <div class="head-info-block">
            <div style="width:50%; float:left;">
                <div style="margin-top:5px;"><b >Список сообщений</b></div>
            </div>
            <div style="text-align:right; width:50%; float:left;">
                <button class="btn btn-success" @click="clickAddMessageButton()" title="Добавить сообщение">Добавить</button>
            </div>
            <div style="clear:both;"></div>
        </div>

        <div v-if="!is_data_error && messages_list.length" v-for="message in messages_list">

            <div class="well" :id="'message_block_' + message.id"
                 :data-text="message.private ? decodeString(message.text) : message.text"
                 :data-private="message.private">
                <div style="font-weight:bold;">
                    <div style="width:50%; float:left;">@{{ message.user.name }}:</div>
                    <div style="text-align:right; width:50%; float:left;">@{{ message.created_at }}</div>
                </div>
                <div style="clear:both;"></div>
                <div style="margin-top:20px;">
                    @{{ message.private ? decodeString(message.text) : message.text }}
                </div>
                <div style="text-align:right;">
                    <button class="btn btn-primary" @click="clickEditMessageButton(message.id)" title="Редактировать сообщение">Редактировать</button>
                    <button class="btn btn-danger" @click="clickDeleteMessageButton(message.id)" title="Удалить сообщение">Удалить</button>
                </div>
            </div>

        </div>

        <div v-else-if="!is_data_error && !messages_list.length" class="alert alert-info">
            Сообщения отсутствуют
        </div>

        <div v-if="is_data_error" class="alert alert-error">
            Не удалось получить данные! Попобуйте перезагрузить страницу.
        </div>

    </div>
</div>
@endsection

@section('modal')
    <div id="js-modals-block">

        <input type="hidden" id="js-save-message-url" value="{{ route('home.save_message') }}">
        <input type="hidden" id="js-delete-message-url" value="{{ route('home.delete_message') }}">
        <input type="hidden" id="js-token" value="{{ csrf_token() }}">

        <div id="saveMessageModal" class="modal fade">
            <div class="modal-dialog" role="document">
                <form action="">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3 style="text-align:center;">@{{ send_message_modal_head_title }}</h3>
                    </div>

                    <input type="hidden" id="js-send-message-modal-message-id" name="message_id" value="">

                    <div class="modal-body">

                        <div class="alert alert-error hidden" id="js-send-message-modal-error-block">
                            Сообщение не может быть пустым
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label>
                                <input style="margin:0px;" type="checkbox" id="js-send-message-modal-is-private" name="is_private" value="1">
                                <span>Приватное сообщение</span>
                            </label>
                        </div>

                        <div class="control-group">
                            <textarea style="width: 100%; height: 50px;" id="js-send-message-modal-textarea" name="text"
                                      placeholder="Ваше сообщение..."
                                      required></textarea>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="saveMessage()">Сохранить</button>
                        <button class="btn" data-dismiss="modal">Закрыть</button>
                    </div>

                </form>
            </div>
        </div>

        <div id="deleteMessageModal" class="modal fade">
            <div class="modal-dialog" role="document">
                <form action="">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h3>Удалить сообщение</h3>
                    </div>

                    <input type="hidden" id="js-delete-message-modal-message-id" name="message_id" value="">

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="deleteMessage()">Удалить</button>
                        <button class="btn" data-dismiss="modal">Закрыть</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
@endsection

@section('styles')
    <style>
        .head-info-block{
            background-color:#D9EDF7;
            margin-bottom:20px;
            padding:7px;
            border-radius:5px;
        }
    </style>
@append

@section('scripts')
    <script src="{{ mix('js/messages.js') }}"></script>
@endsection