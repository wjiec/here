/** Event Bus
 * emit and receive event
 */

class EventBus {
    /**
     * trigger event
     *
     * @param event_name
     * @param args
     */
    static emit(event_name, args) {
        // create event bus storage area
        if (!window._event_bus_storage) {
            window._event_bus_storage = {};
        }
        // check event_name exists
        if (event_name in window._event_bus_storage) {
            window._event_bus_storage[event_name].forEach((callback) => {
                callback(...args);
            });
        }
    }

    /**
     * listening event trigger
     *
     * @param event_name
     * @param callback
     */
    static on(event_name, callback) {
        // create event bus storage area
        if (!window._event_bus_storage) {
            window._event_bus_storage = {};
        }
        // push to storage area
        if (!(event_name in window._event_bus_storage)) {
            window._event_bus_storage[event_name] = [];
        }
        // push to callback stack
        window._event_bus_storage[event_name].push(callback);
    }
}

export { EventBus };
