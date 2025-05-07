<?php

namespace App\Http\Controllers;

use Closure;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\ContactMerge;
use Illuminate\Http\Request;
use App\Models\ContactCustomField;
use App\Models\ContactAdditionalField;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function create(Request $request)
    {
        $customFields = CustomField::all();
        return view("contact.create")->with(['customFields' => $customFields]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:150",
            "email" => ["required", "email", "max:150", function (string $attribute, mixed $value, Closure $fail) use ($request) {
                if ($request->email != '') {
                    $exist = Contact::where('iUserId', auth()->user()->id)->where('email', $value)->first();
                    if ($exist) $fail("The email:" . $value . " already exist.");
                }
            }],
            "phone" => ["required", "digits:10", function (string $attribute, mixed $value, Closure $fail) use ($request) {
                if ($request->phone != '') {
                    $exist = Contact::where('iUserId', auth()->user()->id)->where('phone', $value)->first();
                    if ($exist) $fail("The phone number:" . $value . " already exist.");
                }
            }],
            "gender" => "required|in:male,female,other",
            "profile" => 'required|file|mimes:jpg,jpeg,png|max:2048',
            "additional_file" => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [], [
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "gender" => "Gender",
            "profile" => "Profile",
            "additional_file" => "Additional File",
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toArray(), 422);

        $contact = new Contact;
        $contact->iUserId = auth()->user()->id;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->gender = $request->gender;

        $uploadPath = "upload";
        $profileFileName = time() . "_" . $request->profile->getClientOriginalName();
        $request->profile->move(public_path($uploadPath), $profileFileName);
        $contact->profile_image = $uploadPath . "/" . $profileFileName;
        if ($request->hasFile("additional_file")) {
            $additionalFileName = time() . "_" . $request->additional_file->getClientOriginalName();
            $request->additional_file->move(public_path($uploadPath), $additionalFileName);
            $contact->additional_file = $uploadPath . "/" . $additionalFileName;
        }
        $contact->save();


        $customFieldData = collect($request->all())->except([
            'name',
            'email',
            'phone',
            'gender',
            'profile',
            'additional_file',
        ]);

        foreach ($customFieldData as $id => $value) {
            $customField = CustomField::find($id);
            if ($customField && $value != "") {
                $ccf = new ContactCustomField;
                $ccf->iContactId = $contact->id;
                $ccf->iCustomFieldId = $customField->id;
                $ccf->data = $value;
                $ccf->isMerged = "no";
                $ccf->save();
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function edit(Request $request, $id)
    {
        $record = Contact::find($id);

        if (! $record) {
            abort(404);
        }

        $record->load("customdata");

        $customFields = CustomField::all();
        $contactCustomData = json_decode(json_encode($record->customdata), true);
        $contactCustomData = array_reduce($contactCustomData, function ($initial, $element) {
            $initial[$element['id']] = $element['pivot']['data'];
            return $initial;
        }, []);

        return view("contact.update")->with(['customFields' => $customFields, 'contact' => $record, 'contactCustomData' => $contactCustomData]);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);

        if (! $contact) return response()->json(['status' => 'error', 'message' => 'Contact not found'], 404);

        $validator = Validator::make($request->all(), [
            "name" => "required|string|max:150",
            "email" => ["required", "email", "max:150", function (string $attribute, mixed $value, Closure $fail) use ($request, $id) {
                if ($request->email != '') {
                    $exist = Contact::where('iUserId', auth()->user()->id)->where('email', $value)->where('id', '!=', $id)->first();
                    if ($exist) $fail("The email:" . $value . " already exist.");
                }
            }],
            "phone" => ["required", "digits:10", function (string $attribute, mixed $value, Closure $fail) use ($request, $id) {
                if ($request->phone != '') {
                    $exist = Contact::where('iUserId', auth()->user()->id)->where('phone', $value)->where('id', '!=', $id)->first();
                    if ($exist) $fail("The phone number:" . $value . " already exist.");
                }
            }],
            "gender" => "required|in:male,female,other",
            "profile" => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            "additional_file" => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ], [], [
            "name" => "Name",
            "email" => "Email",
            "phone" => "Phone",
            "gender" => "Gender",
            "profile" => "Profile",
            "additional_file" => "Additional File",
        ]);

        if ($validator->fails()) return response()->json($validator->errors()->toArray(), 422);

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->gender = $request->gender;

        $uploadPath = "upload";
        if ($request->hasFile("profile")) {
            $profileFileName = time() . "_" . $request->profile->getClientOriginalName();
            $request->profile->move(public_path($uploadPath), $profileFileName);
            $contact->profile_image = $uploadPath . "/" . $profileFileName;
        }

        if ($request->hasFile("additional_file")) {
            $additionalFileName = time() . "_" . $request->additional_file->getClientOriginalName();
            $request->additional_file->move(public_path($uploadPath), $additionalFileName);
            $contact->additional_file = $uploadPath . "/" . $additionalFileName;
        }

        $contact->save();

        $customFieldData = collect($request->all())->except([
            'name',
            'email',
            'phone',
            'gender',
            'profile',
            'additional_file',
            '_token',
            '_method',
        ]);
        foreach ($customFieldData as $id => $value) {
            ContactCustomField::updateOrCreate(
                ['iContactId' => $contact->id, 'iCustomFieldId' => $id],
                ['data' => $value, 'isMerged' => "no"]
            );
        }

        return response()->json(['status' => 'success']);
    }

    public function destroy(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (! $contact) {
            return response()->json(['status' => 'error', 'message' => 'Contact not found'], 404);
        }

        $contact->delete();

        return response()->json(['status' => 'success']);
    }

    public function index(Request $request)
    {
        $contact = Contact::query()->where('iUserId', auth()->user()->id);
        if ($request->has("search")) {
            $contact = $contact->where(function ($query) use ($request) {
                $query->where('name', 'like', "%" . $request['search'] . "%")
                    ->orWhere('email', 'like', "%" . $request['search'] . "%")
                    ->orWhere('phone', 'like', "%" . $request['search'] . "%");
            });
        }
        if ($request->has("gender")) {
            $contact = $contact->where('gender', $request['gender']);
        }

        $contact = $contact->paginate(10);

        return $request->ajax() ? view('contact.contact_partial')->with(['resources' => $contact]) : view("contact.list")->with(['resources' => $contact]);
    }

    public function show(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (! $contact) {
            abort(404);
        }
        $contactCustomData = json_decode(json_encode($contact->customdata), true);
        $additionalInfo = json_decode(json_encode($contact->additionaldata), true);
        return view("contact.show")->with(['contact' => $contact, 'contactCustomData' => $contactCustomData, 'additionalInfo' => $additionalInfo]);
    }
    public function getContactList(Request $request, $id)
    {
        $contacts = Contact::where("iUserId", auth()->user()->id)->where("id", "!=", $id)->get()->toArray();
        $contacts = array_reduce($contacts, function ($initial, $element) {
            $temp = [];
            $temp['id'] = $element['id'];
            $temp['name'] = $element['name'] . " (" . $element['email'] . ")";
            $initial[] = $temp;
            return $initial;
        }, []);
        return response()->json(['contacts' => $contacts]);
    }

    public function mergeContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'master_contact' => 'required',
            'child_contact' => 'required',
        ], [], [
            'master_contact' => 'Master Contact',
            'child_contact' => 'Child Contact',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toArray(), 422);
        }
        if ($request->master_contact == $request->child_contact) {
            return response()->json(['status' => 'error', 'message' => 'Master and Child contact cannot be same.'], 422);
        }

        $checkIfContactsExist = Contact::whereIn('id', [$request->master_contact, $request->child_contact])->count();
        if ($checkIfContactsExist != 2) {
            return response()->json(['status' => 'error', 'message' => 'Master or Child contact not found.'], 422);
        }

        $masterContact = Contact::find($request->master_contact);
        $childContact = Contact::find($request->child_contact);


        if ($masterContact->email != $childContact->email) {
            ContactAdditionalField::updateOrCreate(
                ['iContactId' => $masterContact->id, 'iChildContactId' => $childContact->id, 'type' => 'email'],
                ['value' => $childContact->email]
            );
        }

        if ($masterContact->phone != $childContact->phone) {
            ContactAdditionalField::updateOrCreate(
                ['iContactId' => $masterContact->id, 'iChildContactId' => $childContact->id, 'type' => 'phone'],
                ['value' => $childContact->phone]
            );
        }

        $cm = new ContactMerge;
        $cm->iMasterContactId = $masterContact->id;
        $cm->iChildContactId = $childContact->id;
        $cm->save();

        $childCustomFields = $childContact->customdata;
        $childCustomFields = json_decode(json_encode($childCustomFields), true);

        foreach ($childCustomFields as $childCustomField) {
            if ($childCustomField['pivot']['data'] == "" || $childCustomField['pivot']['data'] == null) {
                continue;
            }

            $tempRecord = ContactCustomField::where('iContactId', $masterContact->id)->where(function ($query) {
                return $query->where('data', '=', "")->orWhere('data', '=', null);
            })->where('iCustomFieldId', $childCustomField['id'])->first();

            if ($tempRecord) {
                $tempRecord->data = $childCustomField['pivot']['data'];
                $tempRecord->isMerged = "yes";
                $tempRecord->save();
            }

            $tempExist = ContactCustomField::where("iContactId", $masterContact->id)->where("iCustomFieldId", $childCustomField['id'])->first();
            if (!$tempExist) {
                $ccf = new ContactCustomField;
                $ccf->iContactId = $masterContact->id;
                $ccf->iCustomFieldId = $childCustomField['id'];
                $ccf->data = $childCustomField['pivot']['data'];
                $ccf->isMerged = "no";
                $ccf->save();
            }
        }

        $childContact->delete();

        return response()->json(['status' => 'success']);
    }
}
