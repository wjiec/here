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
    // operator result
    let result = undefined;
    // check server environment
    detecting_server_env();
    // receive detecting result
    $.EventBus.on('installer:detecting:complete', (detect_result) => {
        result = detect_result;
    });
    // bind button click event
    $$('#here-installer-next-btn').on('click', (event) => {
        // wrapper on $
        let target_el = $$(event.target);
        // check state
        if (!result || !!target_el.attribute('disabled') || !$$('div[id|="detect"]').length || $$('.detect-item-status-fail').length) {
            // bad man changed HTML or hack blog
            alert('(。・`ω´・)');
        }
        // configure database
        database_configure();
    }, false);

    /**
     * detecting server environment
     */
    function detecting_server_env() {
        // if this script is running in client, that server must enable url rewrite
        (new $.AjaxAdapter()).open('get', '/api/v1/installer/get_detect_list').then((response) => {
            // getting detect list success
            let title = $$('#here-installer-detect-status-bar > p');
            // change title text
            title.text('Detecting Server');
            // from response convert to Object
            let response_object = $.Utility.json_decode(response.text);
            // steps count: using detect is completed
            let steps_count = response_object.steps.length;
            // check status:
            let check_status = { success: 0, fail: 0 };
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
                        $$('#here-installer-next-btn').attribute('disabled', false, true);
                        // send detecting server result
                        $.EventBus.emit('installer:detecting:complete', [{
                            count: steps_count,
                            status: check_status,
                            next_url: response_object.next_step_url
                        }]);
                    }
                    // error displayed [red detecting item]
                }
            });
            // item container
            let container = $$('#here-installer-detect-result');
            // foreach all step and display
            response_object.steps.forEach((step, index) => {
                // make item id
                let item_id = `detect-item-${index}`;
                // push to dom tree
                container.inner_concat(`<div id="${item_id}"><p id="${item_id}-name">${step.name}</p><p id="${item_id}-message"></p></div>`);
                // async to check server
                new Promise((resolve, reject) => {
                    (new $.AjaxAdapter()).open('get', step.address).then((response) => {
                        // check resp
                        let check_response = $.Utility.json_decode(response.text);
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
                    let _selector = $$(response.selector);
                    // message selector
                    let _message = $$(`${response.selector}-message`);
                    // add success class
                    _selector.add_class('detect-item-status-success');
                    // change message text
                    _message.text(response.message);
                    // trigger check success
                    $.EventBus.emit('installer:detecting', [true]);
                }, (response) => {
                    // check error
                    let _selector = $$(response.selector);
                    // message selector
                    let _message = $$(`${response.selector}-message`);
                    // add fail class
                    if (response.level !== 'Error' && response.text === undefined) {
                        // emit installer:detecting:[success] event
                        $.EventBus.emit('installer:detecting', [true]);
                        _selector.add_class('detect-item-status-warning');
                    } else {
                        // emit installer:detecting:[fail] event
                        $.EventBus.emit('installer:detecting', [false]);
                        _selector.add_class('detect-item-status-fail');
                    }
                    // change message text
                    _message.text(response.message || response.text);
                })
            })
        }, (error_response) => {
            // get detect-list error occurs in HTTP request
            console.warn(error_response)
        });
    }

    /**
     * database configuration
     */
    function database_configure() {
        $.History.forward_ajax('get', result.next_url, '#here-installer-contents');
    }
});
