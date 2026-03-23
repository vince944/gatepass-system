<?php

test('guard partial return requires authentication', function () {
    $response = $this->postJson('/guard/gatepass-partial-return', [
        'gatepass_no' => '260001',
        'missing_item_ids' => [1],
    ]);

    $response->assertUnauthorized();
});
