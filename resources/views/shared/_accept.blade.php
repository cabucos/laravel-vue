@can ('accept', $model)
<a title="Mark this as best answer (Click again to undo)" class="{{ $model->status }} mt-2" onClick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();">
    <i class="fas fa-check fa-2x"></i>
</a>
<form id="accept-answer-{{ $model->id }}" action="{{ route('answer.accept', $model->id)}}" method="POST" style="display:none;">
    @csrf
</form>
@else
@if($model->is_best)
<a title="The question owner accepted this as best answer (Click again to undo)" class="{{ $model->status }} mt-2" onClick="event.preventDefault(); document.getElementById('accept-answer-{{ $model->id }}').submit();">
    <i class="fas fa-check fa-2x"></i>
</a>
@endif
@endcan
