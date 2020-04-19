@extends('layouts.app')

@section('content')
    <div class="card shadow container border-bottom-primary pt-4 px-0">
        <div class="card-body p-0">
            <div class="messaging">
                <div class="inbox_msg">
                    <div class="inbox_people">
                        <div class="headind_srch">
                            <div class="recent_heading">
                                <h4 class="text-primary">Üzenetek</h4>
                            </div>
                        </div>
                        <div class="inbox_chat nav nav-pills nav-fill">

                        </div>
                    </div>
                    <div class="mesgs">
                        <div class="msg_history">

                        </div>
                        <div class="type_msg">
                            <div class="input_msg_write">
                                <input type="text" style="outline: none" class="write_msg" placeholder="Üzenet írása..."/>
                                <button class="msg_send_btn rounded-circle text-center p-0 btn btn-primary" type="button">
                                    <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        var authUser = @json(auth()->user());
        var chat = {
            id: null,
            conversations: [],
            createConversation() {
                $.post('{{config('app.url')}}/chat/conversations', {title: 'asdf'});
            },
            loadConversations() {
                $.get('{{config("app.url")}}/chat/conversations').then(data => {
                    this.conversations = data.data;
                    this.id = this.conversations[0].id;
                    this.loadConversation(this.id)
                });
            },
            loadConversation(id) {
                this.id = id;
                $.get('{{config('app.url')}}/chat/conversations/' + id, {
                    participant_id: authUser.id,
                    participant_type: 'App\\User'
                }).then(data => {
                    this.conversation = data;
                    this.render();
                });
            },
            markAllAsRead() {
                $.post('{{config('app.url')}}/chat/conversations/' + this.id + '/read');
            },
            send(message) {
                $.post('{{config('app.url')}}/chat/conversations/' + this.id + '/messages', {
                    participant_id: authUser.id,
                    participant_type: 'App\\User',
                    message: {body: message}
                });
                this.loadConversation(this.id);
            },
            render() {
                //chat tabs
                $('.inbox_chat').html("");
                this.conversations.forEach(convo => {
                    $('.inbox_chat').append(`
                        <div class="nav-item nav-link active ${convo.id == this.id ? 'active_chat' : ''}" data-conv-id="${convo.id}">
                            <div class="">
                                <div class="">
                                    <h5>${convo.conversation.data.title}
                                </div>
                            </div>
                        </div>`);
                })

                $('.msg_history').html('');
                //chat content
                this.conversation.data.forEach(message => {
                    if (message.is_sender == 1) {
                        $('.msg_history').append(
                            `
                       <div class="outgoing_msg">
                            <div class="sent_msg">
                                <p>${message.body}</p>
                                <span class="time_date"> ${message.created_at} </span></div>
                        </div>`
                        );
                    } else {
                        $('.msg_history').append(`
                         <div class="incoming_msg">
                            <div class="incoming_msg_img">
                                <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"></div>
                            <div class="received_msg">
                                <div class="received_withd_msg">
<h6 class="text-primary">${message.sender.name}</h6>
                                    <p>${message.body}</p>
                                    <span class="time_date">${message.created_at}</span></div>
                            </div>
                        </div>`);
                    }
                })
                $('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
            }
        }

        $('.write_msg').on('keypress', function (e) {
            if (e.which == 13) {
                chat.send($('.write_msg').val());
                $('.write_msg').val('')
            }
        });

        $('.msg_send_btn').click(function () {
            chat.send($('.write_msg').val());
            $('.write_msg').val('')
        });

        setInterval(function () {
            chat.loadConversation(chat.id)
        }, 2000);

        $(document).on('click', '.chat_list', function (target) {
            $(this).addClass('active_chat');
            chat.loadConversation($(this).data('conv-id'));
        });

        chat.loadConversations();


    </script>
    <style>
        .container {
            max-width: 1170px;
            margin: auto;
        }

        img {
            max-width: 100%;
        }

        .inbox_people {
            float: left;
            overflow: hidden;
            width: 40%;
        }

        .inbox_msg {
            clear: both;
            overflow: hidden;
        }

        .top_spac {
            margin: 20px 0 0;
        }


        .recent_heading {
            float: left;
            width: 40%;
        }

        .srch_bar {
            display: inline-block;
            text-align: right;
            width: 60%;
            padding:
        }

        .headind_srch {
            padding: 10px 29px 10px 20px;
            overflow: hidden;
            border-bottom: 1px solid #c4c4c4;
        }

        .recent_heading h4 {
            color: #05728f;
            font-size: 21px;
            margin: auto;
        }

        .srch_bar input {
            border: 1px solid #cdcdcd;
            border-width: 0 0 1px 0;
            width: 80%;
            padding: 2px 0 4px 6px;
            background: none;
        }

        .srch_bar .input-group-addon button {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            padding: 0;
            color: #707070;
            font-size: 18px;
        }

        .srch_bar .input-group-addon {
            margin: 0 0 0 -27px;
        }

        .chat_ib h5 {
            font-size: 15px;
            color: #464646;
            margin: 0 0 8px 0;
        }

        .chat_ib h5 span {
            font-size: 13px;
            float: right;
        }

        .chat_ib p {
            font-size: 14px;
            color: #989898;
            margin: auto
        }

        .chat_img {
            float: left;
            width: 11%;
        }

        .chat_ib {
            float: left;
            padding: 0 0 0 15px;
            width: 88%;
        }

        .chat_people {
            overflow: hidden;
            clear: both;
        }

        .chat_list {
            border-bottom: 1px solid #c4c4c4;
            margin: 0;
            padding: 18px 16px 10px;
        }

        .inbox_chat {
            height: 550px;
            overflow-y: scroll;
        }

        .active_chat {
            background: #ebebeb;
        }

        .incoming_msg_img {
            display: inline-block;
            width: 6%;
        }

        .received_msg {
            display: inline-block;
            padding: 0 0 0 10px;
            vertical-align: top;
            width: 92%;
        }

        .received_withd_msg p {
            background: #ebebeb none repeat scroll 0 0;
            border-radius: 3px;
            color: #646464;
            font-size: 14px;
            margin: 0;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .time_date {
            color: #747474;
            display: block;
            font-size: 12px;
            margin: 8px 0 0;
        }

        .received_withd_msg {
            width: 57%;
        }

        .mesgs {
            float: left;
            padding: 30px 15px 0 25px;
            width: 60%;
        }

        .sent_msg p {
            background: #05728f none repeat scroll 0 0;
            border-radius: 3px;
            font-size: 14px;
            margin: 0;
            color: #fff;
            padding: 5px 10px 5px 12px;
            width: 100%;
        }

        .outgoing_msg {
            overflow: hidden;
            margin: 26px 0 26px;
        }

        .sent_msg {
            float: right;
            width: 46%;
        }

        .input_msg_write input {
            background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
            border: medium none;
            color: #4c4c4c;
            font-size: 15px;
            min-height: 48px;
            width: 100%;
        }

        .type_msg {
            border-top: 1px solid #c4c4c4;
            position: relative;
        }

        .msg_send_btn {
            background: #05728f none repeat scroll 0 0;
            border: medium none;
            border-radius: 50%;
            color: #fff;
            cursor: pointer;
            font-size: 17px;
            height: 33px;
            position: absolute;
            right: 0;
            top: 11px;
            width: 33px;
        }

        .msg_history {
            height: 516px;
            overflow-y: auto;
        }
    </style>
@endsection