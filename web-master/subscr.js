function subscribe() {
    $.ajax({
        url: "web-master/mySubscriptions.php",
        cache: false,
        success: function(html) {
            $("#table").html(html);

        }
    });
}


document.addEventListener('click', function() {
    var button = event.target;

    // кнопка подписаться на предложение
    if (button.tagName === 'INPUT' && button.type === 'button' && button.className === 'subscr_button') {
        let $linkСost = prompt('Подтвердите стоимость перехода по ссылке');

        let data = {
            of_name: button.id,
            cost: $linkСost,
        };

        $.ajax({
            url: 'web-master/subscribe.php',
            type: 'POST',
            data: data,
            error: function() {
                console.log('Ошибка!');
            },
            success: function($a) {
                console.log($a);
                if ($a == 1) {
                    alert('Цена не соответствует указанной рекламодателем!');
                };
                subscribe();
            }
        })
    }

    // кнопка отписаться от предложения
    if (button.tagName === 'INPUT' && button.type === 'button' && button.className === 'unsubscr_button') {
        let data = {
            of_id: button.id,
        };
        $.ajax({
            url: 'web-master/unsubscribe.php',
            type: 'POST',
            data: data,
            error: function() {
                console.log('Ошибка!');
            },
            success: function() {
                subscribe();
            }
        })
    }
});