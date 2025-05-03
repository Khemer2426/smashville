<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2">
            <div class="flex-grow-1">
                <h1 class="h4 fw-bold mb-2">
                    {{ __($page_title) }}
                </h1>
                @if (isset($sub_title) && !empty($sub_title))
                <h2 class="fs-base lh-base fw-medium text-muted mb-0">
                    {{ __($sub_title) }}
                </h2>
                @endif
            </div>
            <nav class="flex-shrink-0 mt-3 mt-sm-0 ms-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    @if (!empty($breadcrumbs))
                        @foreach($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item">
                            <a class="link-fx" href="{{ $breadcrumb['url'] }}">{{ __($breadcrumb['title']) }}</a>
                        </li>
                        @endforeach
                    <li class="breadcrumb-item" aria-current="page">
                        {{ __($page_title) }}
                    </li>
                    @endif
                </ol>
            </nav>
        </div>
    </div>
</div>