# caravy

Simple PHP framework, following the mvc-pattern

### TODO:

#### Routing:

-   [x] handle if request can not be matched
-   [x] add concrete controller handling
-   [x] seperate get and post route (controller, action)

#### View:

-   [x] extend render engine with some tags and blocks -> Catch all @-tags and parse them to the matching compiler. Like Laravel

###### Blocks:

-   [x] @if ... @endif
-   [ ] @else ... @endif
-   [x] @foreach ... @endforeach
-   [x] @for ... @endfor
-   [x] @while ... @endwhile
-   [ ] @php ... @endphp (raw php)

###### Tags:

-   [x] @yield
-   [ ] @csrf
-   [x] @method
-   [x] @include

#### Database:

-   [x] add database integration as middleware

#### User and Permissions:

-   [x] add user-management

### Permissions:

###### User:

-   user_create
-   user_delete
-   user_edit

###### Post:

-   post_create
-   post_delete
-   post_edit
-   post_publish

###### Kalender:

-   internal_calendar_entry_create
-   internal_calendar_entry_delete
-   internal_calendar_entry_edit

###### Knowledge-DB:

-   internal_knowledge_entry_create
-   internal_knowledge_entry_delete
-   internal_knowledge_entry_edit

###### Downloads:

-   download_create
-   download_delete

###### Downloads-internal:

-   internal_download_create
-   internal_download_delete
