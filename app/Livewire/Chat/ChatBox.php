<?php

namespace App\Livewire\Chat;

use App\Notifications\MessageRead;
use Livewire\Component;
use App\Models\Message;
use App\Notifications\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatBox extends Component
{
    public $selectedConversation;
    public $loadedMessages;
    public $body = "";

    public $paginate_var = 10;

    protected $listeners = [
        'loadMore'
    ];

    public function getListeners()
    {
        $auth_id= auth()->user()->id;

        return [
            'loadMore',
            "echo-private:users.{$auth_id},.Illuminate\\Notifications\\Events\\BroadcastNotificationCreated"=>'broadcastedNotifications'
        ];
    }

    public function broadcastedNotifications($event)
    {
        if($event['type'] == MessageSent::class) {
            if($event['conversation_id'] == $this->selectedConversation->id) {

                $this->dispatch('scroll-bottom');

                $newMessage = Message::find($event['message_id']);

                #push message
                $this->loadedMessages->push($newMessage);

                #mark as read
                $newMessage->read_at = now();
                $newMessage->save();

                #broadcast
                $this->selectedConversation->getReceiver()
                    ->notify(new MessageRead($this->selectedConversation->id));
            }
        }
    }

    public function loadMore() : void
    {
        #increment
        $this->paginate_var += 10;

        #call loadMessages()
        $this->loadMessages();

        #update the chat height
        $this->dispatch('update-chat-height');
    }

    public function loadMessages()
    {
        #get count
        $count  = Message::where('conversation_id', $this->selectedConversation->id)->count();

        #skip and query
        $this->loadedMessages = Message::where('conversation_id', $this->selectedConversation->id)
        ->skip($count - $this->paginate_var)
        ->take($this->paginate_var)
        ->get();
    }

    public function sendMessage()
    {
        $this->validate(['body' => 'required|string']);

        $createdMessage = Message::create([
            'conversation_id' => $this->selectedConversation->id,
            'sender_id' => auth()->id(),
            'receiver_id' => $this->selectedConversation->getReceiver()->id,
            'body' => $this->body,
        ]);

        $this->reset("body");

        #scroll to bottom
        $this->dispatch('scroll-bottom');

        #push the message
        $this->loadedMessages->push($createdMessage);

        #update conversation model
        $this->selectedConversation->updated_at= now();
        $this->selectedConversation->save();

        #refresh chat list
        $this->dispatch('chat.chat-list', 'refresh');

        #broadcast
        $this->selectedConversation->getReceiver()
                    ->notify(new MessageSent(
                        Auth()->User(),
                        $createdMessage,
                        $this->selectedConversation,
                        $this->selectedConversation->getReceiver()->id
                    ));
    }

    public function mount()
    {
        $this->loadMessages();
    }

    public function render()
    {
        return view('livewire.chat.chat-box');
    }
}
