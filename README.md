# caravy

Simple PHP framework, following the mvc-pattern

### TODO:

#### Routing:
- handle if request can not be matched
- add concrete controller handling
- seperate get and post route (controller, action)

#### View:
- extend render engine with some tags and blocks -> Catch all @-tags and parse them to the matching compiler. Like Laravel

###### Blocks:
- [x] @if ... @endif
- [ ] @else ... @endif
- [x] @foreach ... @endforeach
- [x] @for ... @endfor
- [x] @while ... @endwhile
- [ ] @php ... @endphp

###### Tags:
- [x] @yield
- [ ] @csrf
- [ ] @method
- [ ] @include

#### Database:
- add database integration as middleware

#### User and Permissions:
- add user-management