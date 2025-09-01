<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use App\Models\DocumentType;

class MessageComponent extends Component
{
    public $messages, $message, $document_type_id, $message_id;
    public $updateMode = false;
     public $isModalOpen = false;

    // protected $rules = [
    //     'message' => 'required|string|max:255',
    //     'document_type_id' => 'required|exists:document_types,id',
    // ];

    public function render()
    {

        $messagesList = Message::with('documentType')->get();
        $documentTypes = DocumentType::all();
        return view('livewire.message-component', compact('messagesList','documentTypes')
        )->layout('layouts.admin.admin');
    }

    public function resetInputFields(): void
    {
        $this->message = '';
        $this->document_type_id = '';
        $this->message_id = '';
    }
    public function openModal()
    {
        $this->resetInputFields();
        $this->isModalOpen = true;
    }
    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function store(): void
    {
        // dd($this);
        //  $this->validate();
        //   $this->validate([
        //     'message' => 'required|string|max:255',
        //  'document_type_id' => 'required|exists:document_types,id',
        // ]);


        Message::updateOrCreate(
            ['id' => $this->message_id],
            [
                'message' => $this->message,
                'document_type_id' => $this->document_type_id,
            ]
        );

        session()->flash(
            'message',
            $this->message_id ? 'Message updated.' : 'Message created.'
        );

        $this->resetInputFields();
        $this->updateMode = false;
        $this->closeModal();
    }

    public function edit(int $id): void
    {
        if ($message = Message::find($id)) {
            $this->message_id = $message->id;
            $this->message = $message->message;
            $this->document_type_id = $message->document_type_id;
            $this->updateMode = true;
        } else {
            session()->flash('message', 'Message not found.');
        }
         $this->updateMode = true;
        $this->isModalOpen = true;
    }

    public function delete(int $id): void
    {
        if (Message::find($id)?->delete()) {
            session()->flash('message', 'Message deleted successfully.');
        } else {
            session()->flash('message', 'Message not found.');
        }

        $this->resetInputFields();
        $this->updateMode = false;
        
    }
}
