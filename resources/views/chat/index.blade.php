@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div id="chat">
                <div class="row">
                    <div class="col-3">
                        <div class="nav flex-column nav-pills" id="chat-conversations" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                            <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</a>
                            <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
                        </div>
                    </div>
                    <div class="col-9">
                        <div>
                            convo
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var chat = {
            conversations: [],
            createConversation() {
                $.post('chat/conversations', {title: 'asdf'});
            },
            loadConversations() {
                $.get('chat/conversations').then(data => {
                    this.conversations = data;
                    this.render();
                });
            },
            render() {
                $('#chat #chat-conversations').html("");

                this.conversations.each(convo => {
                    $('#chat #chat-conversations').append(`<a class="nav-link active conversation" aria-selected="true">${convo}</a>`);
                })
            }
        }

        $(document).on('click', '.conversation', function (target){
            console.log(target);
        });

        chat.loadConversations();


    </script>
@endsection