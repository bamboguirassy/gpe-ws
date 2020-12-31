import { Route } from "@angular/router";
import { <?= $entity_class_name ?>ListComponent } from './<?= strtolower($entity_class_name) ?>-list/<?= strtolower($entity_class_name) ?>-list.component';
import { <?= $entity_class_name ?>NewComponent } from './<?= strtolower($entity_class_name) ?>-new/<?= strtolower($entity_class_name) ?>-new.component';
import { <?= $entity_class_name ?>EditComponent } from './<?= strtolower($entity_class_name) ?>-edit/<?= strtolower($entity_class_name) ?>-edit.component';
import { <?= $entity_class_name ?>CloneComponent } from './<?= strtolower($entity_class_name) ?>-clone/<?= strtolower($entity_class_name) ?>-clone.component';
import { <?= $entity_class_name ?>ShowComponent } from './<?= strtolower($entity_class_name) ?>-show/<?= strtolower($entity_class_name) ?>-show.component';
import { Multiple<?= $entity_class_name ?>Resolver } from './multiple-<?= strtolower($entity_class_name) ?>.resolver';
import { One<?= $entity_class_name ?>Resolver } from './one-<?= strtolower($entity_class_name) ?>.resolver';

const <?= $entity_var_singular ?>Routes: Route = {
    path: '<?= strtolower($entity_class_name) ?>', children: [
        { path: '', component: <?= $entity_class_name ?>ListComponent, resolve: { <?= $entity_var_singular ?>s: Multiple<?= $entity_class_name ?>Resolver } },
        { path: 'new', component: <?= $entity_class_name ?>NewComponent },
        { path: ':id/edit', component: <?= $entity_class_name ?>EditComponent, resolve: { <?= $entity_var_singular ?>: One<?= $entity_class_name ?>Resolver } },
        { path: ':id/clone', component: <?= $entity_class_name ?>CloneComponent, resolve: { <?= $entity_var_singular ?>: One<?= $entity_class_name ?>Resolver } },
        { path: ':id', component: <?= $entity_class_name ?>ShowComponent, resolve: { <?= $entity_var_singular ?>: One<?= $entity_class_name ?>Resolver } }
    ]

};

export { <?= $entity_var_singular ?>Routes }
