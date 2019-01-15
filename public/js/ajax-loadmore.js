
Array.from(document.querySelectorAll('a.js-loadmore')).forEach(function (link) {
    link.addEventListener('click', onClickLink);
});

async function onClickLink(event) {
    event.preventDefault();
    const url = this.href;

    try {
        const result = await axios.post(url);
        const data = result.data;

    } catch (error) {
        if (error.response.status === 403) {
            window.location = '/login'
        }
    }
}
