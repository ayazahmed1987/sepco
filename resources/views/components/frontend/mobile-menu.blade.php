@foreach ($items as $item)
    @php
        $isParent = !$item->parent;
        $isChild = $item->parent;
        $hasChildren = $item->children->count() > 0;
    @endphp

    <li class="">
        @if ($isParent && $hasChildren)
            <a href="{{ $item->redirect_url }}">{{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}
                <span><i class="fas fa-angle-down"></i></span></a>
            <ul class="sub_menu">
                <x-frontend.menu :items="$item->children" />
            </ul>
        @else
            <a href="{{ $item->redirect_url }}">{{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}</a>
        @endif
    </li>
@endforeach
