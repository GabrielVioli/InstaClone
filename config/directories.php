<?php

return [
    'service_dirs_initialized' => function() {
        @mkdir(base_path('app/Services'), 0755, true);
        @mkdir(base_path('app/Exceptions'), 0755, true);
        @mkdir(base_path('app/Policies'), 0755, true);
        return true;
    }
];
