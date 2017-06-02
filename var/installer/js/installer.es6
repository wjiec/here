/**
 * Installer Guide Scripts
 *
 * @pack Here
 * @author ShadowMan
 */

/* global $, $$ */
$.ready(function() {
    let _document = new $(document);
    // disable right-button
    _document.on('contextmenu', () => false, false);
    // disable text-selection
    _document.on('selectstart', () => false, false);
    // installer guide all step info
    let step_urls = [];
    // current step index
    let current_step_index = 0;
    // get step information from server
    (new $.AjaxAdapter()).open('get', '/api/v1/installer/get_step_info').then((response) => {
        step_urls = $.Utility.json_decode(response.text);
    }, (error_response) => {
        console.log(error_response);
    });

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
                        $.EventBus.emit('installer:step:complete');
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
                    });
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
                });
            });
        }, (error_response) => {
            // get detect-list error occurs in HTTP request
            console.warn(error_response);
        });
    }

    /**
     * setting database
     */
    function database_configure() {
        // getting form data
        let host = $$('#here-installer-db-host');
        let port = $$('#here-installer-db-port');
        let username = $$('#here-installer-db-username');
        let password = $$('#here-installer-db-password');
        let database = $$('#here-installer-db-name');
        let table_prefix = $$('#here-installer-db-prefix');
        // PHP 5.6+ does't support text/json POST request, only support application/x-www.form-urlencoded
        (new $.AjaxAdapter()).open('PUT', '/api/v1/installer/database_configure', null, {
            host: host.value(),
            port: port.value(),
            username: username.value(),
            password: password.value(),
            database: database.value(),
            table_prefix: table_prefix.value()
        }, null, 'json').then((response) => {
            console.log(response);
        }, (error_response) => {
            console.log(error_response);
        })
    }

    /**
     * admin username/password configure
     */
    function admin_configure() {
        console.log('admin_configure');
    }

    /**
     * blogger title and other information
     */
    function site_configure() {
        console.log('site_configure');
    }

    /**
     * complete install and redirection to index page
     */
    function complete_install() {
        console.log('complete_configure');
    }

    // callbacks
    let step_callback = [
        detecting_server_env,
        function() {
            $.History.forward_ajax('get', step_urls[current_step_index++], '#here-installer-contents');
        },
        database_configure,
        admin_configure,
        site_configure,
        complete_install
    ];
    // callback result state [default is true]
    let callback_state = true;
    // change state
    $.EventBus.on('installer:step:complete', () => {
        // set callback state
        callback_state = true;
        // enable button
        $$('#here-installer-next-btn').attribute('disabled', false, true);
    });
    // listening changed event
    $$('#here-install-body').on('change', (event) => {
        // event origin
        let target_el = $$(event.target);
        // origin tag name
        let tag_name = target_el.attribute('tagName');
        // check result
        let complete_num = 0;
        // check is input widget
        if (tag_name.toLowerCase() === 'input') {
            $$('input').foreach((el, index) => {
                if (el.value().length) {
                    complete_num += 1;
                }
            })
        }
        // emit installer:step:complete event?
        if (complete_num === $$('input').length) {
            $.EventBus.emit('installer:step:complete');
            // step_callback[current_step_index - 1]();
        }
    }, true);
    // bind button click event
    $$('#here-installer-next-btn').on('click', (event) => {
        // button element instance
        let target_el = $$(event.target);
        // execute callback
        let callback = step_callback[current_step_index];
        // button disabled state
        let disabled_state = target_el.attribute('disabled');
        // check state
        if ((disabled_state === null || disabled_state === false)) {
            // execute callback
            callback();
            // check callback state
            if (callback_state === true) {
                // reset button state
                target_el.attribute('disabled', true, true);
                // reset callback result
                callback_state = false;
                // detecting-server have't own page, both first page.
                if (current_step_index === 0) {
                    current_step_index += 1;
                } else {
                    // request next step page
                    // $.History.forward_ajax('get', step_urls[current_step_index++], '#here-installer-contents');
                }
                // change to `Next`
                target_el.text('Next');
            }
        }
    }, false);
});
