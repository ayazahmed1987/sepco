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
    <li>
            @if ($isParent)
                <a href="{{ $item->redirect_url }}"><i class="bi bi-chevron-double-right"></i> {{ app()->getLocale() == 'en' ? $item->title : $item->title_ur }}</a>
            @endif
    </li>
@endforeach