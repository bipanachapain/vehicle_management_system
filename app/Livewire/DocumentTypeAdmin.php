<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DocumentType;
class DocumentTypeAdmin extends Component
{
     public $documentTypes, $name, $duration, $docId;
    public $isOpen = false;
    public $editMode = false;
    public function render()
    {
         $this->documentTypes = DocumentType::all();
        return view('livewire.document-type')->layout('layouts.admin.admin');
    }
    public function create()
    {
        $this->resetFields();
        $this->isOpen = true;
         $this->editMode = false;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'duration' => 'required|integer',
        ]);

        DocumentType::updateOrCreate(['id' => $this->docId], [
            'name' => $this->name,
            'duration' => $this->duration
        ]);

         session()->flash('message', 'Document Update.');
        $this->isOpen = false;
        $this->resetFields();
    }

    public function edit($id)
    {
        $doc = DocumentType::findOrFail($id);
        $this->docId = $doc->id;
        $this->name = $doc->name;
        $this->duration = $doc->duration;
        $this->isOpen = true;
         $this->editMode = true;
        ;
    }

    public function delete($id)
    {
        DocumentType::findOrFail($id)->delete();
    }

    private function resetFields()
    {
        $this->name = '';
        $this->duration = '';
        $this->docId = null;
         $this->editMode = false;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->editMode = false;
    
    }
    
}
