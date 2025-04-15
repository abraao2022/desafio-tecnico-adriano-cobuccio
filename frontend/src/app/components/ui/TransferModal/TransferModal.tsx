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
    to_customer_id: Yup.number().required('ID do cliente de origem é obrigatório'),
    amount: Yup.number().required('Valor é obrigatório').min(0, 'O valor deve ser positivo').max(100000000, 'O valor deve ser menor ou igual a 100000000'),
    description: Yup.string().required('Descrição é obrigatória')
});

export default function TransferModal({ open, handleClose }: { open: boolean; handleClose: () => void }) {

    return (
        <div>
            <Modal open={open} onClose={handleClose} aria-labelledby="modal-modal-title" aria-describedby="modal-modal-description">
                <Box sx={style}>
                    <Formik
                        initialValues={{
                            to_customer_id: 0,
                            amount: 0,
                            description: 'Transferência'
                        }}
                        validationSchema={validationSchema}
                        onSubmit={async (values, { setSubmitting, setStatus }) => {
                            try {
                                await transactionsService.transfer(values.to_customer_id, values.amount, values.description).then(() => {
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
                                    id="to_customer_id"
                                    name="to_customer_id"
                                    label="Enviar para (ID)"
                                    type="number"
                                    value={values.to_customer_id}
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    error={touched.to_customer_id && Boolean(errors.to_customer_id)}
                                    helperText={touched.to_customer_id && errors.to_customer_id}
                                    margin="normal"
                                />

                                <TextField
                                    fullWidth
                                    id="amount"
                                    name="amount"
                                    label="Valor"
                                    type="number"
                                    value={values.amount}
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    error={touched.amount && Boolean(errors.amount)}
                                    helperText={touched.amount && errors.amount}
                                    margin="normal"
                                />

                                <TextField
                                    fullWidth
                                    id="description"
                                    name="description"
                                    label="Descrição"
                                    value={values.description}
                                    onChange={handleChange}
                                    onBlur={handleBlur}
                                    error={touched.description && Boolean(errors.description)}
                                    helperText={touched.description && errors.description}
                                    margin="normal"
                                />

                                <Button type="submit" fullWidth variant="contained" sx={{ mt: 3, mb: 2 }} disabled={isSubmitting}>
                                    {isSubmitting ? 'Transferindo...' : 'Transferir'}
                                </Button>
                            </Form>
                        )}
                    </Formik>
                </Box>
            </Modal>
        </div>
    );
}
