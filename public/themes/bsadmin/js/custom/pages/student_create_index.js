/*
    JS ES 6+
*/

// Onload document
let inputSchool = tagId('row_school_id')
let inputName = tagId('row_name')
let inputSurname = tagId('row_surname')
let inputPersonalId = tagId('row_personal_id')
let inputPhone = tagId('row_phone')
let inputEmail = tagId('row_email')
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
createRegisterProcess = (state = false) => {    
    if(state === true) {        
        tagId('action_btn_save').innerHTML = `<i class="fa fa-spin fa-spinner"></i> wait...`
        tagId('action_btn_save').disabled = true
        tagId('action_btn_cancel').disabled = true
    } else {
        tagId('action_btn_save').innerHTML = `<i class="fa fa-check fa-fw"></i> Create`
        tagId('action_btn_save').disabled = false
        tagId('action_btn_cancel').disabled = false
    }
}
createRegister = (school_id) => {
    let form = Object.create(null)
    let data = Object.create(null)
    let resp = Object.create(null)

    data.school_id = school_id
    data.name = inputName.value
    data.surname = inputSurname.value
    data.personal_id = inputPersonalId.value
    data.phone = inputPhone.value
    data.email = inputEmail.value
    data.country_id = selectorCountry.value
    data.region_id = selectorRegion.value
    data.province_id = selectorProvince.value
    data.city_id = 0//selectorCity.value
    data.address = inputAddress.value    
    
    if ( data.school_id == '' || data.name != '' ) {
        createRegisterProcess (true)

        // Ajax send
        form.url  = AdminPath + '/form/' + Layout
        form.function = Layout
        form.action = 'createRegister'
        form.json = data
        if (inputImage.files.length) form.files = inputImage.files

        formPost(form).then(json => {
            if (json.status == 'error') {
                alert('some error has occured - watch console log')
                console.log(json.message)
            } else if (json.status == 'field') {
                if (json.message.school_id) { saveRegisterAlert(inputSchool, json.message.school_id) }
                else if (json.message.name)        { saveRegisterAlert(inputName, json.message.name) }
                else if (json.message.surname)     { saveRegisterAlert(inputSurname, json.message.surname) }
                else if (json.message.personal_id) { saveRegisterAlert(inputPersonalId, json.message.personal_id) }
                else if (json.message.phone)       { saveRegisterAlert(inputPhone, json.message.phone) }
                else if (json.message.email)       { saveRegisterAlert(inputEmail, json.message.email) }
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
                resp.close = false
                resp.title = `<i class="fa fa-file-text-o fa-wd"></i> Create student's register`
                resp.body = `The register with its information has been created successfully`
                resp.footer = `<a href="${AdminPath}/school/students?id=${data.school_id}" class="btn btn-success""><i class="fa fa-check fa-fw"></i> Close</a>`
                jqueryModal({show: true, data: resp})
                console.log(json)
            }
            createRegisterProcess ()
        }).catch( console.error() )
    }
}
tagId('action_btn_save').addEventListener('click', (e) => {
    id = e.target.dataset.target
    createRegister(id)
})

// Geography
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
    imageSet    = tagId('imageSet')

imageSelect.addEventListener("click", (e) => {
    if (imageElem) imageElem.click()
    e.preventDefault() // prevent navigation to "#"
}, false)

imageElem.addEventListener("change", handleFiles, false);

function handleFiles() {
    // for multiple files upload add attribute "multiple" to input tag and remove "this.files.length" condition
    if (!this.files.length || this.files.length != 1) {        
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
                    imageList.innerHTML = `<p>No files selected!</p>`
                    e.preventDefault(e)
                }, false)
            }
        }
    }
}