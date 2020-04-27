 @if (!empty($errors))
                    <div>
                    @if(is_object($errors))
                        @foreach ($errors->all() as $error)
                            <script>alert('{{$error}}')</script>
                        @endforeach
                    @else
                    <script>alert('{{$errors}}')</script>
                @endif   
                     </div>
@endif