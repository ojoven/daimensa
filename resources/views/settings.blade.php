@extends('layouts.main')
@section('class', 'home')

@section('content')

    <h1>Settings</h1>

    <!-- INTRO -->
    <section>

        <div class="form">

            <div class="form-control">

                <label>My mother tongue is:</label>
                <select name="settings_mother_tongue" id="settings_mother_tongue">
                    <option value="es">Spanish</option>
                </select>

            </div>

            <div class="form-control">

                <label>The language I want to practice:</label>
                <select multiple name="settings_languages" id="settings_languages">
                    <option value="fr">Français</option>
                </select>

            </div>

            <div class="form-control">

                <a id="to-save-settings" href="#">Save</a>

            </div>

        </div>

    </section>

@stop