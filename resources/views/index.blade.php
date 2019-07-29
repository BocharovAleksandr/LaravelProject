@extends('layout.main')

@section('content')
<div class="row-fluid">
    <div class="span2"></div>
    <div class="span8">

        <form action="" method="post" class="form-horizontal" style="margin-bottom: 50px;">
            @csrf
            <div class="alert alert-error">
                Сообщение не может быть пустым
            </div>

            <div class="control-group">
                <textarea style="width: 100%; height: 50px;" type="password" id="inputText" placeholder="Ваше сообщение..."
                          data-cip-id="inputText"></textarea>
            </div>
            <div class="control-group">
                <button type="submit" class="btn btn-primary">Отправить сообщение</button>
            </div>
        </form>


        <div class="well">
            <h5>Eugene:</h5>
            Привет! Как твои дела?
        </div>

        <div class="well">
            <h5>Mikle:</h5>
            Цикл, без использования формальных признаков поэзии, диссонирует мелодический скрытый смысл,
            но не рифмами. Эстетическое воздействие, не учитывая количества слогов, стоящих между ударениями,
            притягивает реципиент, заметим, каждое стихотворение объединено вокруг основного философского стержня.
        </div>

        <div class="well">
            <h5>Tony:</h5>
            Метафора выбирает мифологический поток сознания, несмотря на отсутствие единого пунктуационного алгоритма.
            Матрица абсурдно нивелирует подтекст, особенно подробно рассмотрены трудности, с которыми сталкивалась
            женщина-крестьянка в 19 веке. Комбинаторное приращение нивелирует мелодический дискурс, несмотря на
            отсутствие единого пунктуационного алгоритма. Расположение эпизодов вызывает литературный эпитет, также
            необходимо сказать о сочетании метода апроприации художественных стилей прошлого с авангардистскими стратегиями.
        </div>

        <div class="well">
            <h5>Andre:</h5>
            Развивая эту тему, типизация отталкивает амфибрахий – это уже пятая стадия понимания по М.Бахтину.
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script src="{{ mix('js/messages.js') }}"></script>
    @endsection