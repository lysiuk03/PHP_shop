Explain
<header>
    <!-- Фіксована навігаційна панель -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/">Каталог</a>

            <!-- Кнопка для згортання/розгортання меню на малих екранах -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Контейнер для пунктів меню та пошукової форми -->
            <div class="collapse navbar-collapse" id="navbarCollapse">

                <!-- Список пунктів меню -->
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Головна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Посилання</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">Вимкнено</a>
                    </li>
                </ul>

                <!-- Форма для пошуку -->
                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Пошук" aria-label="Пошук">
                    <button class="btn btn-outline-success" type="submit">Пошук</button>
                </form>
            </div>
        </div>
    </nav>
</header>
