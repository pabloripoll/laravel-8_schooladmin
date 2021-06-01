/*
    JS ES 6+
*/

let listId   = tagId('list-filter-id')
let listName = tagId('list-filter-name')
let listRows = tagId('list-filter-rows')
let listPage = tagId('list-filter-page')

let currentListPage  = tagId('current-page').innerHTML
let currentListRows  = listRows.value
let currentOrderId   = listId.value

let filterId   = tagAll('li.list-filter-id')
let filterRows = tagAll('li.list-filter-rows')
let filterPage = tagAll('li.paginate_button')

// List fiters *
// -> Order - simple
filterId.forEach( (elem) => {
    elem.addEventListener("click", (e) => {
        tagId('list-filter-id-text').innerHTML = e.target.text
        listId.value = e.target.dataset.target
        e.preventDefault(e)
        paginateList()
    }, false)
})
tagId('list-filter-id-text').innerHTML = tag('[data-target="'+ currentOrderId +'"]').innerHTML
// -> Limit rows per page
filterRows.forEach( (elem) => {
    elem.addEventListener("click", (e) => {
        value = e.target.dataset.target
        tagId('list-filter-rows-text').innerHTML = `Show ${value} rows`
        listRows.value = value
        e.preventDefault(e)
        paginateList()
    }, false)
})
tagId('list-filter-rows-text').innerHTML = `Show ` + tag('[data-target="'+ currentListRows +'"]').innerHTML + ` rows`
// -> Pagination
let resetFilterPage = () => {
    filterPage.forEach( (e) => {
        e.classList.remove('active')
    })
}
filterPage.forEach( (elem) => {
    elem.addEventListener("click", (e) => {
        resetFilterPage()
        value = e.target.dataset.target
        if (tagId('paginate_button_'+ value)) {
            tagId('paginate_button_'+ value).classList.add('active')
        }
        listPage.value = e.target.dataset.target
        //
        e.preventDefault(e)
        paginateList()
    }, false)
})

let paginateList = () => {
    Page = listPage.value
    Rows = listRows.value
    orderById = listId.value
        
    query = `?page=${Page}`
    if (Rows != currentListRows) {
        query = `?page=1`
        query += `&limit=${Rows}`
    }
    if (orderById != currentOrderId) query += `&order=${orderById}`

    self.location.replace(query) // reload page
}