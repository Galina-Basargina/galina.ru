<?php
function send($url)
{
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	$res = curl_exec($curl);
	// var_dump($res);
    echo $res;
}

function updateCity($id, $data)
{
    $url = 'http://galina.ru/lab_19/db-api.php?action=edit&id='.$id;
    
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($curl);
    curl_close($curl);
    
    return $response;
}
// Получение страницы
// send('http://basargina.ru');

// Получение даты в разных форматах
// send('http://galina.ru/lab_19/day.php');
// send('http://galina.ru/lab_19/month.php');
// send('http://galina.ru/lab_19/year.php');
// send('http://galina.ru/lab_19/weekday.php?date=2025-04-25');
// send('http://galina.ru/lab_19/days_between.php?date1=2024-04-25&date2=2025-04-25');

// Работа с базой данных
// send('http://galina.ru/lab_19/db-api.php?country=2');
// send('http://galina.ru/lab_19/db-api.php?action=all');
// send('http://galina.ru/lab_19/db-api.php?action=get&id=4');
// send('http://galina.ru/lab_19/db-api.php?action=del&id=4');

$updatedData = [
    'sity' => 'New City Name',
    'country' => 1
];
// echo updateCity(1, $updatedData);

// send('https://api.adviceslip.com/advice');

function send_advice()
{
    send('https://api.adviceslip.com/advice');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    </head>
<body>
    <div>
        <h1>Случайные советы</h1>
        <button onclick="getAdvice()">Получить совет</button>
        <button onclick="saveAdvice()">Сохранить совет</button>
        <div id="current-advice" class="advice-box"></div>
        
        <h2>Сохранённые советы</h2>
        <div id="saved-list-advice"></div>
        <button onclick="clearSavedAdvice()">Очистить сохранённые</button>
    </div>
    <br>
    
    <div class="tabs">
        <button class="tab-button active" onclick="switchTab('cats')">Кошки</button>
        <button class="tab-button" onclick="switchTab('dogs')">Собаки</button>
    </div>

    <div id="cats-content" class="content active">
        <div class="fact-box" id="cats-fact"></div>
        <button onclick="getNewFact('cats')">Новый факт</button>
        <button onclick="saveFact('cats')">Сохранить</button>
    </div>

    <div id="dogs-content" class="content">
        <div class="fact-box" id="dogs-fact"></div>
        <button onclick="getNewFact('dogs')">Новый факт</button>
        <button onclick="saveFact('dogs')">Сохранить</button>
    </div>

    <div id="saved-facts">
        <h2>Сохранённые факты</h2>
        <div id="saved-list-animals"></div>
        <button onclick="clearSavedAnimals()">Очистить</button>
    </div>

    <script>
        let save_advices = JSON.parse(localStorage.getItem('advices')) || [];
        let current_tab = 'cats';
        let save_facts = JSON.parse(localStorage.getItem('animalFacts')) || {cats: [], dogs: []};

        updateSavedListAnimals();

        async function getAdvice() {
            try {
                const response = await fetch('https://api.adviceslip.com/advice');
                const data = await response.json();
                document.getElementById('current-advice').innerHTML = `
                    <strong>Совет #${data.slip.id}</strong>
                    <p>${data.slip.advice}</p>
                `;
            } catch (error) {
                console.error('Ошибка при получении совета:', error);
                document.getElementById('current-advice').innerHTML = 
                    'Не удалось получить совет. Попробуйте ещё раз.';
            }
        }

        function saveAdvice() {
            const currentAdvice = document.getElementById('current-advice').textContent;
            if (!save_advices.includes(currentAdvice)) {
                save_advices.push(currentAdvice);
                localStorage.setItem('advices', JSON.stringify(save_advices));
                updateSavedListAdvice();
            }
        }

        function updateSavedListAdvice() {
            const list = document.getElementById('saved-list-advice');
            list.innerHTML = save_advices
                .map((advice, index) => `
                    <div class="advice-box">
                        <strong>Совет #${index + 1}</strong>
                        <p>${advice}</p>
                    </div>
                `)
                .join('');
        }

        function clearSavedAdvice() {
            localStorage.removeItem('advices');
            save_advices = [];
            updateSavedListAdvice();
        }

        window.onload = () => {
            updateSavedListAnimals();
            getNewFact('cats');
        }

        // Переключение вкладок
        function switchTab(tab) {
            document.querySelectorAll('.content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
            
            document.getElementById(`${tab}-content`).classList.add('active');
            document.querySelector(`[onclick="switchTab('${tab}')"]`).classList.add('active');
            
            current_tab = tab;
            getNewFact(tab);
        }

        async function getNewFact(type) {
            try {
                const url = type === 'cats' 
                    ? 'https://catfact.ninja/fact' 
                    : 'https://dogapi.dog/api/v2/facts';
                
                const response = await fetch(url);
                const data = await response.json();
                
                const fact = type === 'cats' 
                    ? data.fact 
                    : data.data[0].attributes.body;
                
                document.getElementById(`${type}-fact`).innerHTML = fact;
                const a = 9;
            } catch (error) {
                console.error('Ошибка:', error);
                document.getElementById(`${type}-fact`).innerHTML = 
                    'Не удалось загрузить факт';
            }
        }

        function saveFact(type) {
            const fact = document.getElementById(`${type}-fact`).textContent;
            
            if (fact.trim() && !save_facts[type].includes(fact)) {
                save_facts[type].push(fact);
                localStorage.setItem('animalFacts', JSON.stringify(save_facts));
                updateSavedListAnimals();
            }
        }

        function updateSavedListAnimals() {
            const list = document.getElementById('saved-list-animals');
            list.innerHTML = '';
            
            for (const type in save_facts) {
                save_facts[type].forEach((fact, index) => {
                    list.innerHTML += `
                        <div class="fact-box">
                            <strong>${type === 'cats' ? 'Кошка' : 'Собака'} #${index + 1}</strong>
                            <p>${fact}</p>
                        </div>
                    `;
                });
            }
        }

        function clearSavedAnimals() {
            localStorage.removeItem('animalFacts');
            save_facts = {cats: [], dogs: []};
            updateSavedListAnimals();
        }
    </script>
</body>
</html>