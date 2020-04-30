<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{ $answersCount  ." ". str_plural('Answer', $answersCount) }}</h2>
                </div>
                <hr>
                @foreach($answers as $answer)
                <div class="media">
                    <div class="d-flex flex-column vote-controls">
                        <a title="This answer is useful" class="vote-up">
                            <i class="fas fa-caret-up fa-3x"></i>
                        </a>
                        <span class="vote-count">1230</span>
                        <a title="This answer is not useful" class="vote-down off">
                            <i class="fas fa-caret-down fa-3x"></i>
                        </a>
                        @can ('accept', $answer)
                        <a title="Mark this as best answer (Click again to undo)" class="{{ $answer->status }} mt-2" onClick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();">
                            <i class="fas fa-check fa-2x"></i>
                        </a>
                        <form id="accept-answer-{{ $answer->id }}" action="{{ route('answer.accept', $answer->id)}}" method="POST" style="display:none;">
                            @csrf
                        </form>
                        @else
                            @if($answer->is_best)
                                <a title="The question owner accepted this as best answer (Click again to undo)" class="{{ $answer->status }} mt-2" onClick="event.preventDefault(); document.getElementById('accept-answer-{{ $answer->id }}').submit();">
                                    <i class="fas fa-check fa-2x"></i>
                                </a>
                            @endif
                        @endcan
                    </div>
                    <div class="media-body">
                        @parsedown ($answer->body)
                        <div clas="row">
                            <div class="col-sm-4">
                                <div class="ml-auto">
                                    @can('update', $answer)
                                    <a href="{{ route('question.answer.edit', [$question->id, $answer->id]) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                    @endcan

                                    @can('delete', $answer)
                                    <form class="form-delete" method="post" action="{{ route('question.answer.destroy', [$question->id, $answer->id]) }}">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onClick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            </div>

                        </div>
                        <div class="float-right">
                            <span class="text-muted">Answered {{ $answer->created_date }}</span>
                            <div class="media mt-2">
                                <a href="{{ $answer->user->url }}" class="pr-2">
                                    <img src="{{ $answer->user->avatar }}">
                                </a>
                                <div class="media-body mt-1">
                                    <a href="{{ $answer->user->url }}">{{ $answer->user->name }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
