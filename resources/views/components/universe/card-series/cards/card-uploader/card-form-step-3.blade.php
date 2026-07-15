


@if(View::exists('components.universe.card-series.cards.card-uploader.card-type-forms.'.$card_type_form))

    @include('components.universe.card-series.cards.card-uploader.card-type-forms.'.$card_type_form)
@else
    @include('components.universe.card-series.cards.card-uploader.card-type-forms.default')
@endif

