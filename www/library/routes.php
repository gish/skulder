<?php
R('')->controller('Index')->action('index')->on('GET');
R('debt/?')->controller('Debt')->action('add')->on('POST');
R('debt/([0-9]+)/?')->controller('Debt')->action('get')->on('GET');
R('debt/([0-9]+)/?')->controller('Debt')->action('update')->on('PUT');
R('debt/([0-9]+)/?')->controller('Debt')->action('delete')->on('DELETE');
R('debts/?')->controller('Debts')->action('get')->on('GET');
R('own/?')->controller('Own')->action('get')->on('GET');
