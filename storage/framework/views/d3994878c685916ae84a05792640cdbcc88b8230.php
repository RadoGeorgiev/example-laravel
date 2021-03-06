<!doctype html>
<html lang="bg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Бикове и крави</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
    />
    <!-- MDB -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.css"
        rel="stylesheet"
    />
    <!-- MDB -->
    <script
        type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.3.0/mdb.min.js"
    ></script>
    <link rel="stylesheet" href="<?php echo e(asset('/css/game.css')); ?>">
    <script type="text/javascript" src="<?php echo e(asset('/js/game.js')); ?>"></script>
</head>
<body onload="getTop('tries')">
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid justify-content-between">
        <span class="navbar-brand">
            <a href="/game"><img src="<?php echo e(asset('bullcowkiss.gif')); ?>" width="100px"></a>
            <span>Бикове и крави</span>
        </span>
        <button class="btn btn-outline-primary me-2" type="button" onclick="newGame()">Нова игра</button>
        <button
            id="popover"
            type="button"
            class="btn btn-outline-secondary me-2"
            data-mdb-toggle="popover"
            title="Как се играе?"
            data-mdb-content="Бикове и крави е традиционна игра, в която трябва да бъде позната намислена комбинация от цифри.
            Програмата генерира комбинация от 4 уникални цифри (една и съща цифра не може да се среща повече от веднъж, комбинацията може да започва с 0). След като започнете играта, трябва да въведете своето предположение и ще получите резултат под формата на брой бикове и брой крави.
            Един бик означава, че е позната една цифра и тя е поставена на точното си място; Крава обозначава, че цифрата присъства в комбинацията, но не е поставена на правилното място.
            Играта приключва, когато познаете точно генерираната комбинация, което се равнява на 4 бика.
            Ако решите да се откажете, можете да изберете Предавам се, при което ще видите коя е била генерираната комбинация.
            Приятна игра!"
        >
            Правила
        </button>
        <span class="navbar-brand">
            <i class="fas fa-user-secret"></i>
            <span style="cursor: pointer" id="player-name" onclick="editName()"><?php echo e(session('name')); ?></span>
        </span>
    </div>
</nav>
<main class="container">
    <div class="card text-center w-50" id="enter-name" <?php if(session('name')): ?> style="display: none" <?php endif; ?> >
        <div class="card-body">
            <h2 class="card-title">Добре дошли!</h2>
            <h5 class="card-text">Моля, въведете своето име, за да започнете.</h5>
            <form onsubmit="event.preventDefault(); newGame()">
                <div class="mb-3">
                    <input class="form-control" type="text" id="name-input" minlength="3" required>
                </div>
                <button class="btn btn-success" type="submit">Нова игра</button>
            </form>
        </div>
    </div>
    <div class="card w-50" id="play" style="display: none">
        <div class="card-body">
            <h3 class="card-title">Опитайте се да познаете комбинацията, като въведете 4 уникални цифри:</h3>
            <form class="input-group mb-3" onsubmit="event.preventDefault(); guessNumber()" id="play-form">
                <input class="form-control" type="text" maxlength="4" pattern="^(?:([0-9])(?!.*\1)){4}$" id="guess" required autocomplete="off">
                <button class="btn btn-success" type="submit">Познай</button>
                <button class="btn btn-danger" type="button" onclick="giveUp()">Предавам се</button>
            </form>
            <div id="results" class="card-text"></div>
        </div>
    </div>
    <div class="card text-dark bg-light mb-3">
        <div class="card-body">
            <h5 class="card-title">Топ 10</h5>
            <ul class="nav nav-pills nav-fill">
                <li class="nav-item">
                    <a class="nav-link active" id="top-tries-link" href="#" onclick="changeTab('tries')">по брой опити</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="top-times-link" onclick="changeTab('times')">по време</a>
                </li>
            </ul>
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Име</th>
                    <th scope="col">Опити</th>
                    <th scope="col">Време</th>
                </tr>
                </thead>
                <tbody id="top-tbody">
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    const popover = new mdb.Popover(document.getElementById('popover'));
    let token = document.querySelector('meta[name="csrf-token"]').content;
    let startTime = null;

    function newGame() {
        let name = document.getElementById('name-input').value;
        name = name ? name : document.getElementById('player-name').innerText;
        let json = {name: name};
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('name-input').value = '';
                document.getElementById('enter-name').style.display = 'none';
                document.getElementById('player-name').innerText = name;
                document.getElementById('play-form').hidden = false;
                document.getElementById('guess').value = '';
                document.getElementById('results').innerHTML = '';
                document.getElementById('play').style.display = 'block';
                startTime = Date.now();
            }
            if (this.readyState === 4 && this.status > 200) {
                alert(this.responseText);
            }
        }
        xhttp.open('POST', 'new-game');
        xhttp.setRequestHeader('Content-Type', 'application/json');
        xhttp.setRequestHeader('X-CSRF-TOKEN', token);
        xhttp.send(JSON.stringify(json));
    }

    function guessNumber() {
        let guessTime = Date.now() - startTime;
        let number = document.getElementById('guess').value;
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById('guess').value = '';
                let res = JSON.parse(this.response);
                if (res.win === true) {
                    let notice = document.createElement('div');
                    notice.classList.add('alert', 'alert-success');
                    let time = new Date(parseInt(res.time)).toISOString().slice(11,19);
                    notice.innerText = 'Поздравления! Познахте комбинацията ' + number + '. Опити: ' + res.tries + ', време: ' + time + '.';
                    document.getElementById('results').prepend(notice);
                    document.getElementById('play-form').hidden = true;
                    getActiveTopList();
                }
                else {
                    let par = document.createElement('p');
                    let res = JSON.parse(this.response);
                    par.innerText = number + ' => Бикове: ' + res.bulls + ', Крави: ' + res.cows;
                    document.getElementById('results').prepend(par);
                }
            }
            if (this.readyState === 4 && this.status > 200) {
                alert(this.responseText);
                document.getElementById('guess').value = '';
            }
        }
        xhttp.open('GET', 'check/' + number + '?time=' + guessTime);
        xhttp.send();
    }

    function giveUp() {
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let number = this.responseText;
                let notice = document.createElement('div');
                notice.classList.add('alert', 'alert-danger');
                notice.innerText = 'Не успяхте да познаете комбинацията ' + number + '.';
                document.getElementById('results').prepend(notice);
                document.getElementById('play-form').hidden = true;
            }
        }
        xhttp.open('GET', 'give-up');
        xhttp.send();
    }

    function editName(submit = false) {
        let element = document.getElementById('player-name');
        if (submit !== true) {
            let name = element.innerText;
            element.onclick = null;
            element.alt = name;
            element.innerHTML =
                '<input class="form-control-sm" type="text" value="' + name + '">' +
                '<i class="fas fa-check-circle" onclick="editName(true)"></i>';
        }
        else {
            let name = element.firstElementChild.value;
            if (!name.trim()) {
                alert('Не може да оставите името празно!');
                element.firstElementChild.value = element.alt;
                return;
            }
            let xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    element.innerHTML = this.responseText;
                    element.onclick = editName;
                }
                if (this.readyState === 4 && this.status > 200) {
                    alert(this.responseText);
                }
            }
            xhttp.open('GET', 'edit-name/' + name);
            xhttp.send();
        }
    }

    function getTop(category) {
        let tbody = document.getElementById('top-tbody');
        tbody.innerHTML = '';
        let xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                let res = JSON.parse(this.response);
                let i = 1;
                for (let item of res) {
                    let time = new Date(parseInt(item.time)).toISOString().slice(11,19);
                    let tr = document.createElement('tr');
                    let td0 = document.createElement('td');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    td0.innerText = i.toString();
                    td1.innerText = item.name;
                    td2.innerText = item.tries;
                    td3.innerText = time;
                    tr.append(td0, td1, td2, td3);
                    tbody.append(tr);
                    i++;
                }
            }
        }
        xhttp.open('GET', 'get-top/' + category);
        xhttp.send();
    }

    function changeTab(category) {
        switch (category) {
            case 'tries':
                document.getElementById('top-times-link').classList.remove('active');
                document.getElementById('top-tries-link').classList.add('active');
                getTop('tries');
                break;
            case 'times':
                document.getElementById('top-tries-link').classList.remove('active');
                document.getElementById('top-times-link').classList.add('active');
                getTop('times');
                break;
        }
    }

    function getActiveTopList() {
        if (document.getElementById('top-times-link').classList.contains('active')) {
            getTop('times');
        }
        else {
            getTop('tries');
        }
    }
</script>
</body>
</html>
<?php /**PATH /home/rado-pcloud/pcloud/example/example-app/resources/views/game.blade.php ENDPATH**/ ?>