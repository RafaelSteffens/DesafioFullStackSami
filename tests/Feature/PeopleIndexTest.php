<?php

test('pagina de listagem de pessoas carrega com sucesso', function () {
    $response = $this->get('/pessoas');

    $response->assertStatus(200);
});
