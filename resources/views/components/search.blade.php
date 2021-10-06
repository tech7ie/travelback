<v-custom-search
    :routes = "{{json_encode($routeList)}}"
    :current = "{{($currentRoute)}}"
    :current_route_places = "{{($currentRoutePlaces)}}"
    :debug = "{{json_encode($debug)}}"
{{--    :currentRoutes = "'currentRoute'"--}}
    from="{{ $_GET['from'] ?? '' }}"
    to="{{ $_GET['to'] ?? '' }}"
    passengers="{{ $_GET['passengers'] ?? '' }}"
    date="{{ $_GET['from'] ?? '' }}"
    luggage="{{ $_GET['luggage'] ?? '' }}"
>
</v-custom-search>
