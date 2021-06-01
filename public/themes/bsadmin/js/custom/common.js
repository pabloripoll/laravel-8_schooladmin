/*
    COMMON JS
*/

const tag		= document.querySelector.bind(document)
const tagAll	= document.querySelectorAll.bind(document)
const tagId		= document.getElementById.bind(document)
const tagClass	= document.getElementsByClassName.bind(document)
const tagName	= document.getElementsByTagName.bind(document)

/*
	ajax & data post
*/
async function jsonPost(data) {
	const postRequest = await fetch(data.url, {
		method: 'POST',
		headers: {
			'X-CSRF-TOKEN': csrf_token,
			Accept: "application/json",
			dataType: "json",
			contentType: 'application/json',
		},
		body: JSON.stringify(data)
	});
	const postRespond = await postRequest.json();	
	return postRespond;
}

async function formPost(form) {	
    formData = new FormData()
    formData.append('_token', csrf_token)
	if (form.function) formData.append('function', form.function)
	if (form.action) formData.append('action', form.action)
	if (form.json) formData.append('json', JSON.stringify(form.json))	
	if (form.files) {
		formData.append('enctype', 'multipart/form-data')
		files = form.files
		for (let i = 0; i < files.length; i++) {
			formData.append('file-'+[i], files[i])
		}
	}
	const postRequest = await fetch(form.url, {
		method: 'POST',
		body: formData
	});
	const postRespond = await postRequest.json();	
	return postRespond;
}

/*
	formats
*/
const formatBytes = (bytes, decimals = 2) => {
    if (bytes === 0) return '0 Bytes'
    k = 1024
    dm = decimals < 0 ? 0 : decimals
    sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']
    i = Math.floor(Math.log(bytes) / Math.log(k))
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i]
}

/*
	general actions 
*/
tagId('logout-btn').addEventListener("click", function(e) {
    document.forms['logout-form'].submit()
    e.preventDefault()
}, false);

/*
	JQUERY
*/
jqueryModal = ({show, data}) => {
	show  = show || false
	data  = data || Object.create(null)

	if ( !('close' in data) || data.close === true) {
		data.close  = `<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>`
		data.backDrop = ``
	} else { data.close = ''; data.backDrop = `data-backdrop="static" data-keyboard="false"` }
	if ( !('title' in data) ) data.title = `no title`
	if ( !('body' in data) ) data.body = `no body`
	if ( !('bodyAlign' in data) ) data.bodyAlign = `center`
	if ( !('footer' in data) ) data.footer = `<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>`

	if(show === false){
		$('#modal').modal('hide')
	} else {
		let div = document.createElement(`div`)
		div.className = `modal-wrapper`;
		div.innerHTML =
		`<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true" style="display:none;" ${data.backDrop}>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						${data.close}
						<h5 class="modal-title">${data.title}</h5>
					</div>
					<div class="modal-body text-${data.bodyAlign}">`+ data.body +`</div>
					<div class="modal-footer">${data.footer}</div>
				</div>
			</div>
		</div>`
		document.body.appendChild(div);
		$('#modal').modal('show')
	}
	$('#modal').on('hidden.bs.modal', function () {
		$('.modal-wrapper').remove()
	});
}

