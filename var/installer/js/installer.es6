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
    // step url index
    let step_url_index = 0;
    // storage all token
    let step_token = {};
    // get step information from server
    (new $.AjaxAdapter()).open('get', '/api/v1/installer/get_step_info').then((response) => {
        step_urls = $.Utility.json_decode(response.text);
    }, (error_response) => {
        // display error message
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
        let driver = $$('#here-installer-db-driver');
        let host = $$('#here-installer-db-host');
        let port = $$('#here-installer-db-port');
        let username = $$('#here-installer-db-username');
        let password = $$('#here-installer-db-password');
        let database = $$('#here-installer-db-name');
        let table_prefix = $$('#here-installer-db-prefix');
        let charset = $$('#here-installer-db-charset');
        // bind focus event
        $$('input').on('focus', () => {
            // hidden message
            $$('#here-installer-db-success').add_class('widget-hidden');
            $$('#here-installer-db-fail').add_class('widget-hidden');
            // change state
            $.EventBus.emit('installer:step:fail', [current_step_index === 3]);
        });
        // PHP 5.6+ does't support text/json POST request, only support application/x-www.form-urlencoded
        (new $.AjaxAdapter()).open('PUT', '/api/v1/installer/database_configure', null, {
            driver: driver.value(),
            host: host.value(),
            port: port.value(),
            username: username.value(),
            password: password.value(),
            dbname: database.value(),
            table_prefix: table_prefix.value(),
            charset: charset.value()
        }, null, 'json').then((response) => {
            // response text
            let response_object = $.Utility.json_decode(response.text || '{}');
            // remove hidden widget
            $$('#here-installer-db-success').remove_class('widget-hidden');
            // change client_information
            $$('#here-installer-database-client-info').text(response_object.client_info);
            // change server_information
            $$('#here-installer-database-server-info').text(response_object.server_info);
            // display success info and check btn disabled attribute
            if ($$('#here-installer-db-success').has_class('widget-hidden') === false) {
                // current step complete
                $.EventBus.emit('installer:step:complete');
                // save token
                step_token.database_token = response_object.token;
            }
        }, (error_response) => {
            // response text
            let response_object = $.Utility.json_decode(error_response.text || '{}');
            // remove hidden widget
            $$('#here-installer-db-fail').remove_class('widget-hidden');
            // display error message
            $$('#here-installer-database-fail-message').text(response_object.error);
            // change state
            $.EventBus.emit('installer:step:fail', [current_step_index === 3]);
        });
    }

    /**
     * admin username/password configure
     */
    function admin_configure() {
        // getting form data
        let username = $$('#here-installer-account-username');
        let password = $$('#here-installer-account-password');
        // validator status
        let validator_status = true;
        // bind focus event
        $$('input').on('focus', (event) => {
            // get current input
            let input = $$(event.target);
            // remove border-color
            input.set_style('borderColor', '');
            // hidden widget
            $$('#here-installer-account-info').add_class('widget-hidden');
        });
        // username validator
        (new $.FormValidator($$('#here-installer-account-username').real_dom_object(), {
            min_length: 6,
            max_length: 16
        })).then((el, status, message) => {
            el.set_style('borderColor', status ? '#0F0' : '#F00');
            // display error message
            if (status === false) {
                // change state
                validator_status = false;
                // show widget
                $$('#here-installer-account-info').remove_class('widget-hidden');
                // error message
                $$('#here-installer-account-message').text('Username: ' + message);
            }
        });
        // password validator
        (new $.FormValidator($$('#here-installer-account-password').real_dom_object(), {
            min_length: 8,
            max_length: 24
        })).then((el, status, message) => {
            el.set_style('borderColor', status ? '#0F0' : '#F00');
            // display error message
            if (status === false) {
                // change state
                validator_status = false;
                // show widget
                $$('#here-installer-account-info').remove_class('widget-hidden');
                // error message
                $$('#here-installer-account-message').text('Password: ' + message);
            }
        });
        // if validator fail, than quit
        if (validator_status === false) {
            return;
        }
        // PHP 5.6+ does't support text/json POST request, only support application/x-www.form-urlencoded
        (new $.AjaxAdapter()).open('PUT', '/api/v1/installer/account_configure', null, {
            username: username.value(),
            password: password.value(),
        }, null, 'json').then((response) => {
            // response text
            let response_object = $.Utility.json_decode(response.text || '{}');
            // save token
            step_token.account_token = response_object.token;
            // next step
            $.EventBus.emit('installer:step:complete');
            // display success
            $$('#here-installer-account-message').text('account create completed');
            // disable input widget
            $$('#here-installer-account-username').attribute('disabled', true, true);
            $$('#here-installer-account-password').attribute('disabled', true, true);
        }, (error_response) => {
            // response text
            let response_object = $.Utility.json_decode(error_response.text || '{}');
            // remove hidden widget
            $$('#here-installer-account-info').remove_class('widget-hidden');
            // display error message
            $$('#here-installer-account-message').text(response_object.error);
        });
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

    /**
     * request next step contents
     */
    function load_next_step() {
        // load next step page
        $.History.forward_ajax('get', step_urls[++step_url_index], '#here-installer-contents');
        // emit installer:step:complete
        $.EventBus.emit('installer:step:complete');
    }

    // callbacks
    let step_callback = [
        detecting_server_env,
        // database configure
        load_next_step,
        database_configure,
        // admin account configure
        load_next_step,
        admin_configure,
        // blogger information configure
        load_next_step,
        site_configure,
        // complete install display
        load_next_step,
        complete_install
    ];

    // callback result state [default is true]
    let callback_state = true;
    // change state
    $.EventBus.on('installer:step:complete', (increase = true) => {
        // set callback state
        callback_state = true;
        // enable button
        $$('#here-installer-next-btn').attribute('disabled', false, true);
        // increase current step index
        current_step_index += (increase ? 1 : 0);
    });
    // change state to fail
    $.EventBus.on('installer:step:fail', (decrease = true) => {
        // set callback state
        callback_state = false;
        // enable button
        $$('#here-installer-next-btn').attribute('disabled', true, true);
        if (decrease === true) {
            console.log('decrease');
        }
        // decrease current step index
        current_step_index -= (decrease ? 1 : 0);
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
            $$('input').foreach((el) => {
                if (el.value().length) {
                    complete_num += 1;
                }
            });
        }
        // emit installer:step:complete event?
        if (complete_num === $$('input').length) {
            // $.EventBus.emit('installer:step:complete');
            // enable `next` button
            $$('#here-installer-next-btn').attribute('disabled', false, true);
        }
    }, true);
    // bind button click event
    $$('#here-installer-next-btn').on('click', (event) => {
        // button element instance
        let target_el = $$(event.target);
        // execute callback
        let callback = step_callback[current_step_index];
        // button disabled state
        let disabled_state = target_el.attribute('disabled', null, true);
        // check state
        if ((disabled_state === null || disabled_state === false)) {
            // execute callback
            callback();
        }
        // check callback state
        if (callback_state === true) {
            // reset button state
            target_el.attribute('disabled', true, true);
            // reset callback result
            callback_state = false;
            // change to `Next`
            target_el.text('Next');
        }
    }, false);
});
