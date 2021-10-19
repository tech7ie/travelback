<v-custom-search
    :routes = "{{json_encode($routeList)}}"
    :current = "{{($currentRoute)}}"
    :current_route_places = "{{($currentRoutePlaces)}}"
    :debug = "{{json_encode($debug)}}"
{{--    :currentRoutes = "'currentRoute'"--}}
    from="{{ $_GET['from'] ?? '' }}"
    to="{{ $_GET['to'] ?? '' }}"
    adults="{{ $_GET['adults'] ?? '' }}"
    childrens="{{ $_GET['childrens'] ?? '' }}"
    luggage="{{ $_GET['luggage'] ?? '' }}"
    data="{{ $_GET['data'] ?? '' }}"
    hours="{{ $_GET['hours'] ?? '' }}"
    minutes="{{ $_GET['minutes'] ?? '' }}"
>
</v-custom-search>
