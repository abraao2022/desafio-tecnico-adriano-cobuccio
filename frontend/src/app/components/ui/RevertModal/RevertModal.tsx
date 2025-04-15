import * as React from 'react';
import Box from '@mui/material/Box';
import Modal from '@mui/material/Modal';
import { Alert, Button, TextField } from '@mui/material';
import { Form, Formik } from 'formik';
import * as Yup from 'yup';
import transactionsService from '../../../../../services/transactionsService';

const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: '70%',
    bgcolor: 'background.paper',
    borderRadius: 2,
    boxShadow: 24,
    p: 4
};

const validationSchema = Yup.object({
    transaction_id: Yup.number().required('ID da transação é obrigatório'),
});

export default function RevertModal({ open, handleClose }: { open: boolean; handleClose: () => void }) {

    return (
        <div>
            <Modal open={open} onClose={handleClose} aria-labelledby="modal-modal-title" aria-describedby="modal-modal-description">
                <Box sx={style}>
                    <Formik
                        initialValues={{
                            transaction_id: 0
                        }}
                        validationSchema={validationSchema}
                        onSubmit={async (values, { setSubmitting, setStatus }) => {
                            try {
                                await transactionsService.revert(values.transaction_id).then(() => {
                                    handleClose();
                                });
                            } catch (error: unknown) {
                                if (error instanceof Error) {
                                    setStatus(error.message);
                                } else {
                                    setStatus('An unexpected error occurred');
                                }
                            } finally {
                                setSubmitting(false);
                            }
                        }}
                    >
                        {({ errors, touched, handleChange, handleBlur, values, isSubmitting, status }) => (
                            <Form>
                                {status && (
                                    <Alert severity="error" sx={{ mb: 2 }}>
                                        {status}
                                    </Alert>
                                )}

                                <TextField
                                    fullWidth
                                    id="transaction_id"
                                    name="transaction_id"
                                    label="ID da transação"
                                    type="number"
                                    value={values.transaction_id}
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    error={touched.transaction_id && Boolean(errors.transaction_id)}
                                    helperText={touched.transaction_id && errors.transaction_id}
                                    margin="normal"
                                />

                                <Button type="submit" fullWidth variant="contained" sx={{ mt: 3, mb: 2 }} disabled={isSubmitting}>
                                    {isSubmitting ? 'Revertendo...' : 'Reverter'}
                                </Button>
                            </Form>
                        )}
                    </Formik>
                </Box>
            </Modal>
        </div>
    );
}
