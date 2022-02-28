import {Event} from './Event.js';

export class EventDispatcher {
	
	listeners = [];

	constructor() {
	}

	addEventListener(listenedEvent, bindedFunction) {
		this.listeners.push({
			eventName: listenedEvent,
			callback: bindedFunction
		});
	}

	dispatchEvent(event) {
		let listenersCount = this.listeners.length;
		for(let i = 0; i < listenersCount; i++) {
			if(this.listeners[i].eventName == event.eventName)
				this.listeners[i].callback();
		}
	}
}