<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;
use App\Models\TenderAttachment;
use App\Http\Requests\Backend\TenderAttachmentRequest;
use App\Services\FileService;

class TenderAttachmentController extends Controller
{
    public function create(Tender $tender){
        return view('backend.tenders.tender-attachments.create',compact('tender'));
    }

    public function store(TenderAttachmentRequest $request){
        try{
            $Tender = Tender::where('id', $request->tender_id)->first();
            if(!$Tender){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            $data = $request->validated();
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                $data['file'] = FileService::upload($data['file'], 'uploads/tender-attachments/files');
            }
            TenderAttachment::create($data);
            return redirect()->route('manager.tenders.edit', [$Tender])->with('success', 'Tender attachment has been inserted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(TenderAttachment $tender_attachment){
        return view('backend.tenders.tender-attachments.edit',compact('tender_attachment'));
    }

    public function update(TenderAttachmentRequest $request, TenderAttachment $tender_attachment){
        try{
            $Tender = Tender::where('id', $request->tender_id)->first();
            if(!$Tender){
                return redirect()->back()->with('error', 'Invalid Request!');
            }
            $data = $request->validated();
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                if (isset($tender_attachment->file)) {
                    FileService::delete($tender_attachment->file);
                }
                $data['file'] = FileService::upload($data['file'], 'uploads/tender-attachments/files');
            }
            $tender_attachment->update($data);
            return redirect()->route('manager.tender-attachments.edit', [$tender_attachment])->with('success', 'Tender attachment has been updated!');
        }catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function mediaRemove(TenderAttachment $tender_attachment, $field){
        try{
            FileService::delete($tender_attachment->$field);
            $tender_attachment->$field = '';
            $tender_attachment->save();
            return redirect()->back()->with('success', 'File has been deleted');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }

    public function destroy(TenderAttachment $tender_attachment){
        try{
            $tender_id = $tender_attachment->tender_id;
            FileService::delete($tender_attachment->file);
            $tender_attachment->delete();
            return redirect()->route('manager.tenders.edit', [$tender_id])->with('success', 'Tender attachment has been deleted!');
        }catch(\Exception $e){
            return redirect()->back()->with('error',$e->getMessage());
        }
    }
}
