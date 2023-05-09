(() =>
{
    const getUrl = (values) => `${document.URL.substr(0,document.URL.lastIndexOf('/'))}/userbar.php?${Object.keys(values).map((key) => `${key}=${values[key]}`).join('&')}`;

    document.getElementById('submit').addEventListener('click', () =>
    {
        const parameters = {};

        for(const id of ['bg', 'text', 'prop', 'x', 'y'])
            parameters[id] = document.getElementById(id).value;

        const imageUrl = getUrl(parameters);
        const resultContainer = document.querySelector('.result');

        resultContainer.querySelector('img').src = imageUrl;
        resultContainer.querySelector('input[type="text"]').value = imageUrl;
        resultContainer.style.display = 'block';
    });
    document.getElementById('bg').value = 'dr.png';
    document.getElementById('text').value = 'v1r.eu';
    document.getElementById('prop').value = 'paradox.png';
    document.getElementById('x').value = '5';
    document.getElementById('y').value = '-6';
    document.getElementById('submit').click();
})();