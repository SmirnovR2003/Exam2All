const ajaxReport = (url, newsId) => {
    BX.ajax.loadJSON(
        url,
        {
            REPORT_ADD: newsId
        },
        (response) => {
            document.getElementById('report-result').textContent = response.content;
        },
    )
}