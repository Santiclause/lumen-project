@extends('layouts.master')
@section('title', 'Dashboard')
@section('scripts')
@parent
<script src="/js/dashboard.js"></script>
<link href="/css/dashboard.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div id="create">
    Create a new note
    <form id="create-form">
        <div class="formitem"><input name="title" class="create-title" tabindex=1><div class="create-submit"><input type="submit" value="Create Note"></div></div>
        <div class="formitem"><textarea name="body" class="create-body" tabindex=1></textarea></div>
    </form>
</div>
<div id="notes"></div>
<div id="note-template" class="hidden note">
    <div class="note-header">
        <span class="title">Title: <span class="note-data note-title editable" data-tag="title" data-type="input"></span></span>
        <div class="header-right">
            <span class="updated">Last Updated: <span class="note-data note-updated" data-tag="updated_at"></span></span>
            <img class="note-edit" src="/img/edit.png" title="Edit Note">
            <img class="note-delete" src="/img/delete.png" title="Delete Note">
        </div>
    </div>
    <div class="note-content">
        <span class="note-data note-body editable" data-tag="body" data-type="textarea"></span>
    </div>
</div>
<div id="note-footer-template" class="hidden note-footer">
    <span class="right button note-cancel">Cancel</span>
    <span class="right button note-save">Save</span>
</div>
@endsection