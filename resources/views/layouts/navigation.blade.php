<div class="sidebar">
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
            data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <p>
                        {{ __('Dashboard') }}
                    </p>
                </a>
            </li>
            <li class="nav-item  has-treeview menu-open">
                <a href="#" class="nav-link">
                    <p>
                        Все события
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" id="events" style="display: block;">
                    @foreach(\App\Models\Event::all() as $eventItem)
                        <li class="nav-item"><a href="{{ route('events.show', ['event' => $eventItem]) }}" class="nav-link">
                                @if(!empty($event) && $eventItem->id === $event?->id)
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>{{$eventItem->title ?? ''}}</p></a></li>
                    @endforeach
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <p>
                        Мои события
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview" id="my-events" style="display: none;">
                    @foreach(auth()->user()->events as $eventItem)
                        <li class="nav-item">
                            <a href="{{ route('events.show', ['event' => $eventItem]) }}" class="nav-link">
                                @if(!empty($event) && $eventItem->id === $event?->id)
                                    <i class="fas fa-circle nav-icon"></i>
                                @else
                                    <i class="far fa-circle nav-icon"></i>
                                @endif
                                <p>{{$eventItem->title ?? ''}}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
    </nav>
</div>

<script>
    window.onload = function () {
        let currentEventId;
        @if(!empty($event))
            currentEventId = {{$event->id}};
        @else
            currentEventId = null;
        @endif

        setInterval(() => {
            createAllEvents(currentEventId);
            createMyEvents(currentEventId);
        }, 30000);
    }

    function getEventLink() {
        const currentUrl = window.location.href;
        const domain = window.location.hostname;
        const schema = currentUrl.substr(0, currentUrl.indexOf("//") + 2);
        return schema + domain + '/events/';
    }

    function createMenuItemForElementByEvents(eventListElement, events, currentEventId = null) {
        eventListElement.innerHTML = '';
        let eventMenuItem = null;
        let eventMenuItemLink = null;
        let eventMenuItemIcon = null;
        let eventMenuItemTitle = null;
        events.forEach((event) => {
            eventMenuItem = document.createElement("li");
            eventMenuItem.classList.add("nav-item");

            eventMenuItemLink = document.createElement("a");
            eventMenuItemLink.classList.add("nav-link");
            eventMenuItemLink.setAttribute('href', getEventLink() + event.id);

            eventMenuItemIcon = document.createElement("i");
            (currentEventId === event.id) ?
                eventMenuItemIcon.classList.add("fas"):
                eventMenuItemIcon.classList.add("far");
            eventMenuItemIcon.classList.add("fa-circle");
            eventMenuItemIcon.classList.add("nav-icon");

            eventMenuItemTitle = document.createElement("p");
            eventMenuItemTitle.innerHTML = ' ' + event.title;

            eventMenuItemLink.appendChild(eventMenuItemIcon);
            eventMenuItemLink.appendChild(eventMenuItemTitle);
            eventMenuItem.appendChild(eventMenuItemLink);
            eventListElement.appendChild(eventMenuItem);
        });

    }

    function createAllEvents(currentEventId) {
        axios.get('{{route('events.index')}}')
            .then(function (response) {
                if (!response.data?.error) {
                    let eventListElement = document.getElementById('events');
                    let events = response.data.result.events ?? [];

                    createMenuItemForElementByEvents(eventListElement, events, currentEventId);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }

    function createMyEvents(currentEventId) {
        axios.get('{{route('events.my')}}')
            .then(function (response) {
                if (!response.data?.error) {
                    const eventListElement = document.getElementById('my-events');
                    let events = response.data.result.events ?? [];

                    createMenuItemForElementByEvents(eventListElement, events, currentEventId);
                }
            })
            .catch(function (error) {
                console.log(error);
            });
    }
</script>
