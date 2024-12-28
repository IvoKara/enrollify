import { usePage as usePageInertia } from "@inertiajs/vue3";
import { InertiaProps } from "@/inertia"

export function usePage() {
    return usePageInertia<InertiaProps>();
}