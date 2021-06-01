/*
    JS ES 6+
*/

// Onload document
let inputName = tagId('row_name')
let inputLicence = tagId('row_licence')
let inputPhone = tagId('row_phone')
let inputEmail = tagId('row_email')
let inputWebsite = tagId('row_website')
let selectorCountry = tagId('row_country')
let selectorRegion = tagId('row_region')
let selectorProvince = tagId('row_province')
let selectorCity = tagId('row_city')
let inputAddress = tagId('row_address')
let inputImage = tagId('imageFile')

inputName.focus()

// Handle errors on UI
saveRegisterAlert = (element = null, message) => {
    tagId('save-action-status').innerHTML = message
    if (element != null) {
        element.previousElementSibling.classList.add('text-danger')
        element.focus()
    }
}
tagAll('.form-control').forEach((element) => {
    element.addEventListener('blur', () => {
        element.previousElementSibling.classList.remove('text-danger')
        tagId('save-action-status').innerHTML = ''
    }) 
})

// Register
updateRegisterProcess = (state = false) => {    
    if(state === true) {        
        tagId('action_btn_save').innerHTML = `<i class="fa fa-spin fa-spinner"></i> wait...`
        tagId('action_btn_save').disabled = true
        tagId('action_btn_cancel').disabled = true
        tagId('action_btn_delete').disabled = true
    } else {
        tagId('action_btn_save').innerHTML = `<i class="fa fa-check fa-fw"></i> Update`
        tagId('action_btn_save').disabled = false
        tagId('action_btn_cancel').disabled = false
        tagId('action_btn_delete').disabled = false
    }
}

updateRegister = (targetID) => {
    let form = Object.create(null)
    let data = Object.create(null)    
    let resp = Object.create(null)

    data.id = targetID
    data.name = inputName.value
    data.licence = inputLicence.value
    data.phone = inputPhone.value
    data.email = inputEmail.value
    data.website = inputWebsite.value    
    data.country_id = selectorCountry.value
    data.region_id = selectorRegion.value
    data.province_id = selectorProvince.value
    data.city_id = 0//selectorCity.value
    data.address = inputAddress.value    
    
    if ( data.id > 0 || data.name != "" ) {
        updateRegisterProcess (true)

        // Ajax send
        form.url  = AdminPath + '/form/' + Layout
        form.function = Layout
        form.action = 'updateRegister'
        form.json = data
        if (inputImage.files.length) {
            form.files = inputImage.files
        } else {
            if (imageDelete && imageDelete.value == 1) data.imageDelete = imageDelete.value
        }

        formPost(form).then(json => {
            if (json.status == 'error') {
                alert('some error has occured - watch console log')
                console.log(json.message)
            } else if (json.status == 'field') {
                if (json.message.name) { saveRegisterAlert(inputName, json.message.name) }
                else if (json.message.licence)     { saveRegisterAlert(inputLicence, json.message.licence) }
                else if (json.message.phone)       { saveRegisterAlert(inputPhone, json.message.phone) }
                else if (json.message.email)       { saveRegisterAlert(inputEmail, json.message.email) }
                else if (json.message.website)     { saveRegisterAlert(inputWebsite, json.message.website) }
                else if (json.message.country_id)  { saveRegisterAlert(selectorCountry, json.message.country_id) }
                else if (json.message.region_id)   { saveRegisterAlert(selectorRegion, json.message.region_id) }
                else if (json.message.province_id) { saveRegisterAlert(selectorProvince, json.message.province_id) }
                else if (json.message.city_id)     { saveRegisterAlert(selectorCity, json.message.city_id) }
                else if (json.message.address)     { saveRegisterAlert(inputAddress, json.message.address) }
                else if (json.message.image) {
                    Object.entries(json.message.image).forEach( ([key, value]) => {
                        if (key == 'size') unit = ` bytes.`; else unit = ` px.`
                        text = `image: ${value}` + unit
                    });
                    saveRegisterAlert(null, text)
                }
                else {
                    message = 'some filed has an error value - watch console log'
                    alert(message)
                    console.log(json.message)
                }
            } else {

                resp.close  = false
                resp.title  = `<i class="fa fa-file-text-o fa-wd"></i> Update school's register`
                resp.body   = `The register's information has been updated successfully`
                resp.footer = `<a href="${AdminPath}/schools" class="btn btn-default pull-left">Back to list</a>
                               <a href="" class="btn btn-success">Close dialogue</a>`
                jqueryModal({show: true, data: resp})
                console.log(json)
            }
            updateRegisterProcess ()
        }).catch( console.error() )
    }
}
tagId('action_btn_save').addEventListener('click', function (e) {
    id = this.dataset.target
    updateRegister(id)
})

// delete register
deleteRegister = function(e) {
    deleteRegister = tagId('action_btn_delete')
    id = deleteRegister.dataset.target
    
    let form = Object.create(null)
    let data = Object.create(null)

    data.id = id

    if ( data.id > 0 ) {

        document.querySelector('.modal-header').innerHTML = `<i class="fa fa-spinner fa-spin"></i> Deleting register`
        document.querySelector('.modal-body').innerHTML = `Please, wait until register is erased`
        document.querySelector('.modal-footer').innerHTML = `<button type="button" class="btn btn-danger"><i class="fa fa-spinner fa-spin"></i>  wait...</button>`

        form.url = AdminPath + '/json/' + Layout
        form.function = Layout
        form.action = 'deleteRegister'
        form.json = data
        jsonPost(form).then(json => {
            if (json.status == 'error') {
                alert('something went wrong - watch console log');
                console.log(json.message)
            } else {

                document.querySelector('.modal-header').innerHTML = `<i class="fa fa-trash fa-fw"></i> Register deleted`
                document.querySelector('.modal-body').innerHTML   = `Register and its dependencies have been deleted`
                document.querySelector('.modal-footer').innerHTML = `<a href="${AdminPath}/schools" class="btn btn-success"><i class="fa fa-check fa-fw"></i>  Back to list</a>`

                console.log(json.message)
            }
        }).catch( console.error() )        
    }
    
}

deleteRegisterDialogue = (id) => {
    let resp    = Object.create(null)
    resp.close  = false
    resp.title  = `<i class="fa fa-exclamation-triangle fa-wd"></i> Delete register`
    resp.body   = `Are you sure to delete <b>${inputName.value}</b> and all its students registers?`
    resp.footer = `<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No, close</button>
                   <button type="button" class="btn btn-danger" id="deleteRegisterDialogueBtn" data-target="${id}">Yes, delete</button>`
    jqueryModal({show: true, data: resp})
}

tagId('action_btn_delete').addEventListener('click', function (e) {
    id = this.dataset.target
    deleteRegisterDialogue(id)
})

/*
    Geography
*/
getRegionProvinces = (region_id) => {
    let form = Object.create(null)
    let data = Object.create(null)

    data.country_id = selectorCountry.value
    data.region_id = region_id

    if ( region_id > 0 ) {
        form.url = AdminPath + '/json/' + Layout
        form.function = Layout
        form.action = 'getRegionProvinces'
        form.json = data
        jsonPost(form).then(json => {
            if (json.status == 'error') {                
                console.log(json.message)
            } else {
                result = json
                options =  `<option selected disabled>- select -</option>`
                result.forEach( (row) => {
                    options +=  `<option value="`+ row['id'] +`">`+ row['name'] +`</option>`
                })
                selectorProvince.innerHTML = options
            }
        }).catch( console.error() )        
    }
}
selectorRegion.addEventListener('change', (e) => {
    getRegionProvinces(`${e.target.value}`)
})

/*
    Image
*/
let imageSelect = tagId('imageSelect'),
    imageElem   = tagId('imageFile'),
    imageList   = tagId('imageList'),
    imageSet    = tagId('imageSet'),
    imageNull   = tagId('imageNull'),
    imageDelete = tagId('imageDelete')

imageSelect.addEventListener("click", (e) => {
    if (imageElem) imageElem.click()
    e.preventDefault() // prevent navigation to "#"
}, false)

imageElem.addEventListener("change", handleFiles, false)

function handleFiles() {
    // for multiple files upload add attribute "multiple" to input tag and remove "this.files.length" condition 
    if (!this.files.length|| this.files.length != 1) {        
        imageList.innerHTML = `<p>No files selected!</p>`
    } else {        
        sizeLimit = 2097152 // 2MB
        imageOverLimit = 0
        for (let i = 0; i < this.files.length; i++) {
            if( this.files[i].size > sizeLimit ) imageOverLimit = parseInt(imageOverLimit) + 1
        }        
        if (imageOverLimit > 0) {
            imageList.innerHTML = "<p>File size is bigger than 2MB - No file selected!</p>"
        } else {
            imageList.innerHTML = ''
            const list = document.createElement("div")
                list.classList.add('text-center')
            imageList.appendChild(list)
            for (let i = 0; i < this.files.length; i++) {
                const img = document.createElement("img")      
                img.src = URL.createObjectURL(this.files[i])
                img.classList.add('img')
                img.onload = () => { URL.revokeObjectURL(this.src) }
                list.appendChild(img)
                const info = document.createElement('p')
                info.innerHTML = this.files[i].name + `<br><b>` + formatBytes(this.files[i].size) + `</b><br>` +
                                 `<a href="#" id="imageRemove">( remove file )</a>`
                list.appendChild(info)
                tagId('imageRemove').addEventListener("click", (e) => {
                    imageElem.value = ''
                    if (imageSet.value) {
                        resetImageSet()
                    } else {
                        imageList.innerHTML = `<p>No files selected!</p>`
                    }
                    e.preventDefault(e)
                }, false)
                imageDelete.value = 0 // important!
            }
        }
    }
}

resetImageSet = () => {
    img = imageSet.value
    imageList.innerHTML = 
    `<div class="text-center">
        <img class="img" src="${img}" />
    </div>
    <p><a href="#" id="imageNull">( remove profile image )</a></p>`
}

dialogueImageNull = () => {
    let resp    = Object.create(null)
    resp.close  = true
    resp.title  = `<i class="fa fa-exclamation-triangle fa-wd"></i> Delete profile image`
    resp.body   = `Are you sure to update this school register without profile image?`
    resp.footer = `<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No, close</button>
                   <button type="button" class="btn btn-danger" onclick="deleteProfileImage()">Yes, remove</button>`
    jqueryModal({show: true, data: resp})
}

deleteProfileImage = () => {
    imageDelete.value = 1
    imageList.innerHTML = `<p>No files selected!</p><p><a href="#" id="retrieveDeletedProfileImage">( retrieve deleted image )</a></p>`
    jqueryModal({show: false, data: null})    
}

retrieveDeletedProfileImage = () => {
    imageDelete.value = 0
    resetImageSet()
}

// Document Events Listener
document.addEventListener('click', (e) => {
    if (e.target && e.target.id == 'imageNull') dialogueImageNull()
    if (e.target && e.target.id == 'retrieveDeletedProfileImage') retrieveDeletedProfileImage()
    if (e.target && e.target.id == 'deleteRegisterDialogueBtn') deleteRegister()
    //e.preventDefault(e)
}, false)