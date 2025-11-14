@foreach ($items as $item)
    @php
        $isParent = !$item->parent;
        $isChild = $item->parent;
        $hasChildren = $item->children->count() > 0;
        if ($isParent && !$isChild) {
            $liClass = 'menu-item';
        } elseif ($isChild && $hasChildren) {
            $liClass = 'sub-sub-menu-h';
        } else {
            $liClass = '';
        }
    @endphp
    <li class="{{ $liClass }}">
        @if ($hasChildren)
            @if ($isParent)
                <span>
                    {{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}
                    <span class="dropdown-icon">▼</span>
                </span>
                <ul class="submenu expertise">
                    <x-frontend.menu :items="$item->children" />
                </ul>
            @else
                <span class="sub-contt">
                    <i class="bi bi-chevron-double-right"></i>
                    {{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}
                    <i class="bi bi-caret-right-fill"></i>
                </span>
                <ul class="sub-sub-menu">
                    <x-frontend.menu :items="$item->children" />
                </ul>
            @endif
        @else
            @if ($isParent)
                <a class="my-menu"
                    href="{{ $item->redirect_url }}">{{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}</a>
            @else
                <a class="" href="{{ $item->redirect_url }}">
                    <i class="bi bi-chevron-double-right"></i>
                    {{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}
                </a>
            @endif
        @endif
    </li>
@endforeach
