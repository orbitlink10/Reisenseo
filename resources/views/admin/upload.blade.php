<!DOCTYPE html>
<html>
<head>
    <title>Laravel 8|7 Drag And Drop File/Image Upload Examle </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/dropzone.min.css" rel="stylesheet">
  
    <style>
        .dropzone {
            background: #e3e6ff;
            border-radius: 13px;
            max-width: 550px;
            margin-left: auto;
            margin-right: auto;
            border: 2px dotted #1833FF;
            margin-top: 50px;
        }
    </style>

    <div id="dropzone">
        <form action="{{ route('dropzoneFileUpload') }}" class="dropzone" id="file-upload" enctype="multipart/form-data">
            @csrf
            <div class="dz-message">
                Drag and Drop Single/Multiple Files Here<br>
            </div>
        </form>
    </div>
