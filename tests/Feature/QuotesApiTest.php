<?php

it('fetches all quotes')->get('/api/quotes')->assertStatus(200);

it('fetches a random quote')->get('/api/quotes/random')->assertStatus(200);

it('fetches a specific quote')->get('/api/quotes/1')->assertStatus(200);
