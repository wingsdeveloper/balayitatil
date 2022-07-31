<div class="Hakkimizda-person-info">
    <div class="container">
        <div class="Hakkimizda-person-info-content flex">
            <div class="Hakkimizda-person-info-in flex a-i-c">

                @forelse($about->workers as $worker)
                    <div class="Hakkimizda-person-item">
                        <h6>{{ $worker->worker_name }}</h6>
                        <p>{{ $worker->worker_position }}</p>
                        <div class="Hakkimizda-person-item-img">
                            @if($worker->worker_photo != null)
                                <img src="{{ImageProcess::getImageByPath( $worker->worker_photo) }}"  alt="Balayı Sepeti - Ekibimiz">
                            @else
                                Resimsiz
                            @endif
                        </div>
                    </div>
                @empty
                    Henüz çalışan eklenmedi
                @endforelse
            </div>
            <div class="Hakkimizda-person-master">
                <div class="Hakkimizda-person-master-in flex">
                    @forelse($about->managers as $manager)
                        <div class="Hakkimizda-person-master-item">
                            <div class="Hakkimizda-person-master-img">
                                @if($manager->manager_photo != null)
                                    <img src="{{ImageProcess::getImageByPath( $manager->manager_photo) }}" alt="Balayı Sepeti - Ekibimiz">
                                @else
                                    Resimsiz
                                @endif
                            </div>
                            <div class="Hakkimizda-person-master-text">
                                <h6>{{ $manager->manager_name }}</h6>
                                <span>{{ $manager->manager_position }}</span>
                                <a href="">{{ $manager->manager_email }}</a>
                            </div>
                        </div>
                    @empty
                        Yönetici Yok
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</div>