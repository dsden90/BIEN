export class Event {
	
	static EVENT = 'generic event';

	listeners = [];
	eventName = null;
	dispatcher = null;

	constructor(eventName) {
		this.eventName = eventName;
	}
}