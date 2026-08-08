<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->get();
        return view('admin.contacts.index', compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->lu = true;
        $contact->save();
        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect()->route('dashboard.admin.contacts.index')->with('success', 'Message supprimé avec succès.');
    }
}
