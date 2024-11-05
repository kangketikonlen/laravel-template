const url = '/report/api/error-log';
const itemList = $("#item-list");
const errorTypeArray = {
    'INFO': 'info',
    'EMERGENCY': 'danger',
    'CRITICAL': 'danger',
    'ALERT': 'warning',
    'ERROR': 'danger',
    'WARNING': 'warning',
    'NOTICE': 'info',
    'DEBUG': 'info',
};

getDataLog(url);

function getDataLog(url) {
    $.get(url, (response) => {
        if (response && response.success) {
            itemList.html(response.data.logs.map(createLogRow).join(''));
            $("#item-list-search").show();
        } else {
            itemList.html(createEmptyRow());
            $("#item-list-search").hide();
        }
    }).fail((xhr, status, error) => console.error('Error:', status, error));
}

function createLogRow(log) {
    return `
        <tr>
            <td class="text-nowrap">${log.timestamp}</td>
            <td class="text-center">${log.env}</td>
            <td class="text-center">
                <span class="badge bg-${errorTypeArray[log.type]}">${log.type}</span>
            </td>
            <td>${log.message}</td>
        </tr>
    `;
}

function createEmptyRow() {
    return `
        <tr>
            <td colspan="5" class="text-center">Tidak ada data</td>
        </tr>
    `;
}

$('select[name="date-log"]').select2({
    theme: 'bootstrap4',
    placeholder: 'Pilih Tanggal Log',
    allowClear: true,
    ajax: {
        url,
        dataType: 'json',
        delay: 250,
        processResults: (response) => ({
            results: response.data.available_log_dates.map(date => ({
                id: date,
                text: date
            }))
        }),
        cache: true
    }
});

$('select[name="date-log"]').on('change', ({ target: { value: date } }) => getDataLog(url + (date ? `?date=${date}` : '')));

