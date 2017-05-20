/**
 * Installer Guide Scripts
 *
 * @pack Here
 * @author ShadowMan
 */
$.ready(function() {
    let _document = new $(document);
    // disable right-button
    _document.on('contextmenu', () => false, false);
    // disable text-selection
    _document.on('selectstart', () => false, false);
    // if this script is running in client, that server must enable url rewrite
    (new $.AjaxAdapter()).open('get', '/api/v1/installer/get_detect_list').then((response) => {
        // getting detect list success
        let title = new $('#here-installer-sd-status-bar > p');
        // change title text
        title.element.innerHTML = 'Detecting Server';
        // from response convert to Object
        let response_object = $.json_decode(response.text);
        // item container
        let container = new $('#here-installer-detect-result').element;
        // steps count: using detect is completed
        let steps_count = response_object.steps.length;
        // check status:
        let check_status = { success: 0, fail: 0 };
        // next button object
        let next_btn = new $('#here-installer-next-btn');
        // listening detect/check event
        $.EventBus.on('installer:detecting', (success) => {
            // check is complete
            if (success === true) {
                check_status.success += 1;
            } else {
                check_status.fail += 1;
            }
            // is complete?
            if (check_status.success + check_status.fail === steps_count) {
                // completed
                if (check_status.fail === 0) {
                    // all success
                    next_btn.element.disabled = false;
                } else {
                    // error occurs
                }
            }
        });
        // bind button click event
        next_btn.on('click', (event) => {
            console.log(event);
        }, false);
        // foreach all step and display
        response_object.steps.forEach((step, index) => {
            // make item id
            let item_id = `detect-item-${index}`;
            // push to dom tree
            container.innerHTML += `<div id="${item_id}"><p id="${item_id}-name">${step.name}</p><p id="${item_id}-message"></p></div>`;
            // async to check server
            new Promise((resolve, reject) => {
                (new $.AjaxAdapter()).open('get', step.address).then((response) => {
                    // check resp
                    let check_response = $.json_decode(response.text);
                    // add selector key
                    check_response.selector = `#${item_id}`;
                    // level
                    check_response.level = step.fail_level;
                    // check status
                    if (check_response.status === 0) {
                        resolve(check_response);
                    }
                    // error occurs
                    reject(check_response);
                }, (response) => {
                    // http error
                    response.selector = `#${item_id}`;
                    reject(response);
                })
            })/* check result handler */.then((response) => {
                // check success
                let _selector = new $(response.selector);
                // message selector
                let _message = new $(`${response.selector}-message`);
                // add success class
                _selector.element.classList.add('detect-item-status-success');
                // change message text
                _message.element.innerHTML = response.message;
                // trigger check success
                $.EventBus.emit('installer:detecting', [true]);
            }, (response) => {
                // check error
                let _selector = new $(response.selector);
                // message selector
                let _message = new $(`${response.selector}-message`);
                // add fail class
                if (response.level !== 'Error' && response.text === undefined) {
                    $.EventBus.emit('installer:detecting', [true]);
                    _selector.element.classList.add('detect-item-status-warning');
                } else {
                    $.EventBus.emit('installer:detecting', [false]);
                    _selector.element.classList.add('detect-item-status-fail');
                }
                // change message text
                _message.element.innerHTML = response.message || response.text;
            })
        })
    }, (error_response) => {
        console.warn(error_response)
    })
});
