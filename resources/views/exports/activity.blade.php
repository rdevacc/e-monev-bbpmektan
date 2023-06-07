{{-- <div class="title" style="padding-bottom: 13px">
    <div style="text-align: center;text-transform: uppercase;font-size: 15px">
        SantriKoding
    </div>
    <div style="text-align: center">
        Alamat: Desa Gedangalas, Kec. Gajah, Kab. Demak
    </div>
    <div style="text-align: center">
        Telp: 0857-9087-9087
    </div>
</div> --}}

<table style="width: 100%">
    <thead>
        <tr class="text-center">
            <th scope="col" class="align-middle">No</th>
            <th scope="col" class="align-middle">Judul Kegiatan</th>
            <th scope="col" class="align-middle">Kelompok</th>
            <th scope="col" class="align-middle">Subkelompok</th>
            <th scope="col" class="align-middle">Penanggung Jawab</th>
            <th scope="col" class="align-middle">Anggaran PJ</th>
            <th scope="col" class="align-middle">Target Keuangan</th>
            <th scope="col" class="align-middle">Realisasi Keuangan</th>
            <th scope="col" class="align-middle">Target Fisik</th>
            <th scope="col" class="align-middle">Realisasi Fisik</th>
            <th scope="col" class="align-middle">Kegiatan yang sudah dikerjakan</th>
            <th scope="col" class="align-middle">Permasalahan</th>
            <th scope="col" class="align-middle">Tindak Lanjut</th>
            <th scope="col" class="align-middle">Kegiatan yang akan dilakukan ({{ $next_month }})
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($activities as $activity )
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $activity->name }}</td>
                <td>{{ $activity->field->name }}</td>
                <td>{{ $activity->group->name }}</td>
                <td>{{ $activity->user->name }}</td>
                <td>{{ $activity->field->budget }}</td>
                <td>{{ $activity->financial_target  }}</td>
                <td>{{ $activity->financial_realization  }}</td>
                <td>{{ $activity->physical_target  }}</td>
                <td>{{ $activity->physical_realization  }}</td>
                <td>
                    @foreach($activity->dones as $done )
                        @if($done["value"])
                            <p>{{ $loop->iteration }}. {{ $done["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
                <td>
                    @foreach($activity->problems as $problem )
                        @if($problem["value"])
                            <p>{{ $loop->iteration }}. {{ $problem["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
                <td>
                    @foreach($activity->follow_up as $follow )
                        @if($follow["value"])
                            <p>{{ $loop->iteration }}. {{ $follow["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
                <td>
                    @foreach($activity->todos as $todo )
                        @if($todo["value"])
                            <p>{{ $loop->iteration }}. {{ $todo["value"] }}</p>
                        @endisset
                    @endforeach
                </td>
            </tr>
        @endforeach
        {{-- @php
            $donesCount = null;
            $problemsCount = null;
            $follow_upCount = null;
            $todosCount = null;
        @endphp

        @foreach ($activities as $activity )
            @php
                $donesCount = $activity->dones ? count($activity->dones) : null;
                $problemsCount = $activity->problems ? count($activity->problems): null;
                $follow_upCount =$activity->follow_up? count($activity->follow_up) : null;
                $todosCount = $activity->todos? count($activity->todos) : null ;
            @endphp


            @if(($donesCount >= $problemsCount) && ($donesCount >= $follow_upCount) && ($donesCount >= $todosCount))
                <tr>
                    <td rowspan="{{ $donesCount }}">{{ $loop->iteration }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->name }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->field->name }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->group->name }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->user->name }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->field->budget }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->financial_target  }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->financial_realization  }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->physical_target  }}</td>
                    <td rowspan="{{ $donesCount }}">{{ $activity->physical_realization  }}</td>
                    @if(!$donesCount == 0 || !$donesCount == null)
                    <td rowspan="{{ $donesCount }}">
                        @foreach ($activity->dones as $done)    
                            <p>{{ $loop->iteration }}. {{ $done["value"] }}</p>
                            @endforeach
                    </td>
                    @else
                    <td rowspan="{{ $donesCount }}"></td>
                    @endif
                    @if(!$problemsCount == 0 ||!$problemsCount == null)
                            <td rowspan="{{ $donesCount }}">
                        @foreach ($activity->problems as $problem)    
                            <p>{{ $loop->iteration }}. {{ $problem["value"] }}</p>
                            @endforeach
                            @endif
                        </td>
                        <td rowspan="{{ $donesCount }}">
                    @if(!$follow_upCount == 0 ||!$follow_upCount == null)
                        @foreach ($activity->follow_up as $follow)    
                            <p>{{ $loop->iteration }}. {{ $follow["value"] }}</p>
                            @endforeach
                            @endif
                        </td>
                        <td rowspan="{{ $donesCount }}">
                    @if(!$todosCount == 0 ||!$todosCount == null)
                        @foreach ($activity->todos as $todo)    
                            <p>{{ $loop->iteration }}. {{ $todo["value"] }}</p>
                            @endforeach
                            @endif
                        </td>
                </tr>
                @endif
            @if (($problemsCount >= $donesCount) && ($problemsCount >= $follow_upCount) && ($problemsCount >= $todosCount))
                <tr>
                    <td rowspan="{{ $problemsCount }}">{{ $loop->iteration }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->name }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->field->name }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->group->name }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->user->name }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->field->budget }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->financial_target  }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->financial_realization  }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->physical_target  }}</td>
                    <td rowspan="{{ $problemsCount }}">{{ $activity->physical_realization  }}</td>
                    @if(!$donesCount == 0 || !$donesCount == null)
                    <td rowspan="{{ $problemsCount }}">
                        @foreach ($activity->dones as $done)    
                            <p>{{ $loop->iteration }}. {{ $done["value"] }}</p>
                        @endforeach
                        @else
                        <td rowspan="{{ $problemsCount }}"></td>
                    @endif
                    @if(!$problemsCount == 0 ||!$prolemsCount == null)
                    <td rowspan="{{ $problemsCount }}">
                        @foreach ($activity->problems as $problem)    
                            <p>{{ $loop->iteration }}. {{ $problem["value"] }}</p>
                            @endforeach
                    @endif
                    @if(!$follow_upCount == 0 ||!$follow_upCount == null)
                    <td rowspan="{{ $problemsCount }}">
                        @foreach ($activity->follow_up as $follow)    
                            <p>{{ $loop->iteration }}. {{ $follow["value"] }}</p>
                            @endforeach
                    @endif
                    @if(!$todosCount == 0 ||!$todosCount == null)
                    <td rowspan="{{ $problemsCount }}">
                        @foreach ($activity->todos as $todo)    
                            <p>{{ $loop->iteration }}. {{ $todo["value"] }}</p>
                            @endforeach
                    @endif
                </tr>
            @endif
        @endforeach --}}
    </tbody>
</table>