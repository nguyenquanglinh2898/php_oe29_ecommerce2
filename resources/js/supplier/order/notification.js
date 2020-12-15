$(document).ready(function() {
    Echo.channel('customer-order')
        .listen('CustomerOrderNotifyEvent', (event) => {
            let unreadNotiNumber = parseInt($('#unreadnoti-counting').text());

            $('#unreadnoti-counting').html(++unreadNotiNumber);

            let notiHtml = `
                <a href="${ event.data.route }"
                   class="header notification-items unread-notification">
                    <span class="thumbnail">
                        <img src="${ event.data.thumbnail }" alt="">
                    </span>
                        <span class="info">
                        <h5 class="notification-message">${ event.data.message }</h5>
                        <h6 class="product-name">${ event.data.products[0]['product']['name'] }</h6>
                        <p class="address"><i>${ event.data.address }</i></p>
                    </span>
                </a>
            `;
            $('#notifications').prepend(notiHtml);
        });
});
