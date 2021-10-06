<v-custom-search
{{--    routes = "@@json($routeList)"--}}
    routes = "test"
    from="{{ $_GET['from'] ?? '' }}"
    to="{{ $_GET['to'] ?? '' }}"
    passengers="{{ $_GET['passengers'] ?? '' }}"
    date="{{ $_GET['from'] ?? '' }}"
    luggage="{{ $_GET['luggage'] ?? '' }}"
></v-custom-search>
