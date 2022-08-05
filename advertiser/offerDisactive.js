function show_messages() {
    $.ajax({
        url: 'advertiser/offers.php',
        cache: false,
        success: function(html) {
            $("#table").html(html);
            buttonLabel();
        }
    });
}

function buttonLabel() {
    let button = document.getElementsByClassName('activity_button');
    for (let i = 0; i < button.length; i++) {
        let but_id = {
            of_name: button[i].id,
        };

        $.ajax({
            url: 'advertiser/offerActivityButtonStatus.php',
            type: 'POST',
            data: but_id,
            error: function() {
                console.log('Ошибка!');
            },
            success: function(a) {
                if (a == 'YES') {
                    button[i].value = 'disact';
                } else button[i].value = 'act';
            }
        })
    }
}

document.addEventListener('DOMContentLoaded', function() {
    buttonLabel();
})

document.addEventListener('click', function() {
    var button = event.target;
    if (button.tagName === 'INPUT' && button.type === 'button' && button.className === 'activity_button') {
        let data = {
            of_name: button.id,
        };

        $.ajax({
            url: 'advertiser/offerActivity.php',
            type: 'POST',
            data: data,
            error: function() {
                console.log('Ошибка!');
            },
            success: function() {
                show_messages();
            }
        })
    }
});