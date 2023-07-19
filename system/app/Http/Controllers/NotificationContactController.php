<?php

namespace App\Http\Controllers;

use App\Models\NotificationContact;
use App\Http\Requests\StoreNotificationContactRequest;
use App\Http\Requests\UpdateNotificationContactRequest;

class NotificationContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNotificationContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNotificationContactRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NotificationContact  $notificationContact
     * @return \Illuminate\Http\Response
     */
    public function show(NotificationContact $notificationContact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NotificationContact  $notificationContact
     * @return \Illuminate\Http\Response
     */
    public function edit(NotificationContact $notificationContact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNotificationContactRequest  $request
     * @param  \App\Models\NotificationContact  $notificationContact
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNotificationContactRequest $request, NotificationContact $notificationContact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NotificationContact  $notificationContact
     * @return \Illuminate\Http\Response
     */
    public function destroy(NotificationContact $notificationContact)
    {
        //
    }
}
