<?php

test('home redirects to tasks', function () {
    $response = $this->get(route('home'));

    $response->assertRedirect(route('tasks.index'));
});
