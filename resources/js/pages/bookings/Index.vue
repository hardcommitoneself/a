<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle, DialogTrigger } from '@/components/ui/dialog';
import { Select, SelectContent, SelectItem, SelectLabel, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useToast } from '@/components/ui/toast/use-toast';
import AppLayout from '@/layouts/AppLayout.vue';
import { Booking, MeetingRoom, type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Booking',
        href: '/bookings',
    },
];

defineProps<{
    bookings: Booking[];
    rooms: MeetingRoom[];
}>();

const { toast } = useToast();

const form = useForm({
    selectedRoom: '',
    startTime: '',
    endTime: '',
});

const bookRoom = async () => {
    form.post(route('bookings.store'), {
        onSuccess: () => {
            toast({
                title: 'Booked',
                description: 'You have booked successfully',
            });
        },
    });
};

const cancelBooking = async (id: number) => {
    // Implement cancellation logic here
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto mt-4 flex max-w-7xl flex-col gap-8">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl">Bookings</h1>

                <Dialog>
                    <DialogTrigger>
                        <Button>Book a room</Button>
                    </DialogTrigger>

                    <DialogContent>
                        <DialogHeader>
                            <DialogTitle>Book a room</DialogTitle>
                            <DialogDescription> Book a room here. Click save when you are done! </DialogDescription>
                        </DialogHeader>

                        <form @submit.prevent="bookRoom" class="flex flex-col gap-6">
                            <div class="grid gap-6">
                                <div class="grid gap-2">
                                    <Label for="selectedRoom">Meeting room</Label>
                                    <Select id="selectedRoom" v-model="form.selectedRoom">
                                        <SelectTrigger>
                                            <SelectValue placeholder="Select a meeting room" />
                                        </SelectTrigger>

                                        <SelectContent>
                                            <SelectLabel>Meeting rooms</SelectLabel>
                                            <SelectItem
                                                v-for="room in rooms"
                                                :value="room.id"
                                                :disabled="!!bookings.find((booking) => booking.meeting_room_id === room.id)"
                                            >
                                                <span>{{ room.name }}</span>
                                                <span v-if="!!bookings.find((booking) => booking.meeting_room_id === room.id)"> - Booked</span>
                                            </SelectItem>
                                        </SelectContent>
                                    </Select>

                                    <InputError :message="form.errors.selectedRoom" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="startTime">Start Time</Label>
                                    <input id="startTime" required type="datetime-local" v-model="form.startTime" />
                                </div>

                                <div class="grid gap-2">
                                    <Label for="endTime">End Time</Label>
                                    <input id="endTime" required type="datetime-local" v-model="form.endTime" />
                                </div>
                            </div>

                            <Button type="submit" class="mt-4 w-full" :disabled="form.processing">
                                <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                                Book
                            </Button>
                        </form>
                    </DialogContent>
                </Dialog>
            </div>

            <Table>
                <TableCaption>A list of your bookings</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead>Room</TableHead>
                        <TableHead>Start Time</TableHead>
                        <TableHead>End Time</TableHead>
                        <TableHead>Actions</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="booking in bookings" :key="booking.id">
                        <TableCell>{{ booking.meeting_room.name }}</TableCell>
                        <TableCell>{{ booking.start_time }}</TableCell>
                        <TableCell>{{ booking.end_time }}</TableCell>
                        <TableCell>
                            <button @click="cancelBooking(booking.id)">Cancel</button>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>
    </AppLayout>
</template>
